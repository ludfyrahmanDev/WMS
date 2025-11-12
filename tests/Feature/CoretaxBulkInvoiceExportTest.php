<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Selling;
use App\Models\Customer;
use App\Models\CV;
use App\Models\Product;
use App\Models\SellingDetail;
use App\Services\CoretaxExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class CoretaxBulkInvoiceExportTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $coretaxService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->coretaxService = new CoretaxExportService();
    }

    /**
     * Test bulk invoice XML generation with valid data
     */
    public function test_can_generate_bulk_invoice_xml()
    {
        // Create test data
        $cv = CV::factory()->create(['npwp' => '083004410361300']);
        $customer = Customer::factory()->create(['npwp' => '031700399461900']);
        $product = Product::factory()->create([
            'code' => '761000',
            'product' => 'Test Product'
        ]);

        // Create multiple sellings
        $sellings = [];
        for ($i = 0; $i < 3; $i++) {
            $selling = Selling::factory()->create([
                'cv_id' => $cv->id,
                'customer_id' => $customer->id,
                'date' => now()->subDays($i),
                'grand_total' => 10000000
            ]);

            SellingDetail::factory()->create([
                'selling_id' => $selling->id,
                'product_id' => $product->id,
                'price_sell' => 25540.54,
                'total_qty' => 500,
                'subtotal' => 12770270
            ]);

            $sellings[] = $selling->id;
        }

        // Generate bulk invoice XML
        $result = $this->coretaxService->generateBulkInvoiceXML($sellings, '0830044103613000');

        // Assertions
        $this->assertIsArray($result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('filepath', $result);
        $this->assertArrayHasKey('total_invoices', $result);
        $this->assertEquals(3, $result['total_invoices']);
        $this->assertFileExists($result['filepath']);

        // Validate XML structure
        $xmlContent = file_get_contents($result['filepath']);
        $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $xmlContent);
        $this->assertStringContainsString('<TaxInvoiceBulk', $xmlContent);
        $this->assertStringContainsString('<TIN>0830044103613000</TIN>', $xmlContent);
        $this->assertStringContainsString('<ListOfTaxInvoice>', $xmlContent);
        $this->assertStringContainsString('<TaxInvoice>', $xmlContent);
        $this->assertStringContainsString('<BuyerName>', $xmlContent);
        $this->assertStringContainsString('<ListOfGoodService>', $xmlContent);

        // Clean up
        if (file_exists($result['filepath'])) {
            unlink($result['filepath']);
        }
    }

    /**
     * Test bulk invoice export endpoint
     */
    public function test_can_export_bulk_invoice_via_endpoint()
    {
        // Create test user with permission
        $user = User::factory()->create();
        $user->givePermissionTo('selling.view');

        // Create test data
        $cv = CV::factory()->create(['npwp' => '083004410361300']);
        $customer = Customer::factory()->create(['npwp' => '031700399461900']);
        $product = Product::factory()->create();

        $selling = Selling::factory()->create([
            'cv_id' => $cv->id,
            'customer_id' => $customer->id
        ]);

        SellingDetail::factory()->create([
            'selling_id' => $selling->id,
            'product_id' => $product->id
        ]);

        // Make request
        $response = $this->actingAs($user)->post(route('selling.coretax-bulk-invoice-export'), [
            'selling_ids' => [$selling->id],
            'seller_tin' => '0830044103613000'
        ]);

        // Assertions
        $response->assertOk();
        $response->assertDownload();
    }

    /**
     * Test validation fails when no selling_ids provided
     */
    public function test_validation_fails_without_selling_ids()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('selling.view');

        $response = $this->actingAs($user)->post(route('selling.coretax-bulk-invoice-export'), [
            'seller_tin' => '0830044103613000'
        ]);

        $response->assertSessionHasErrors('selling_ids');
    }

    /**
     * Test validation fails with invalid selling_ids
     */
    public function test_validation_fails_with_invalid_selling_ids()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('selling.view');

        $response = $this->actingAs($user)->post(route('selling.coretax-bulk-invoice-export'), [
            'selling_ids' => [99999, 99998], // Non-existent IDs
            'seller_tin' => '0830044103613000'
        ]);

        $response->assertSessionHasErrors('selling_ids.0');
    }

    /**
     * Test XML contains correct TIN format
     */
    public function test_xml_contains_correct_tin_format()
    {
        $cv = CV::factory()->create(['npwp' => '08.300.441.0-361.300']);
        $customer = Customer::factory()->create(['npwp' => '03.170.039.9-461.900']);
        $product = Product::factory()->create();

        $selling = Selling::factory()->create([
            'cv_id' => $cv->id,
            'customer_id' => $customer->id
        ]);

        SellingDetail::factory()->create([
            'selling_id' => $selling->id,
            'product_id' => $product->id
        ]);

        $result = $this->coretaxService->generateBulkInvoiceXML([$selling->id], '083004410361300');

        $xmlContent = file_get_contents($result['filepath']);
        
        // Check TIN is cleaned (numeric only)
        $this->assertStringContainsString('<TIN>083004410361300</TIN>', $xmlContent);
        $this->assertStringContainsString('<BuyerTin>031700399461900</BuyerTin>', $xmlContent);
        
        // Clean up
        if (file_exists($result['filepath'])) {
            unlink($result['filepath']);
        }
    }

    /**
     * Test XML escapes special characters properly
     */
    public function test_xml_escapes_special_characters()
    {
        $cv = CV::factory()->create();
        $customer = Customer::factory()->create([
            'name' => 'PT. Test & Company <Ltd>',
            'address' => 'Jl. Test "Street" No. 123'
        ]);
        $product = Product::factory()->create([
            'product' => 'Product with & symbol'
        ]);

        $selling = Selling::factory()->create([
            'cv_id' => $cv->id,
            'customer_id' => $customer->id
        ]);

        SellingDetail::factory()->create([
            'selling_id' => $selling->id,
            'product_id' => $product->id
        ]);

        $result = $this->coretaxService->generateBulkInvoiceXML([$selling->id]);

        $xmlContent = file_get_contents($result['filepath']);
        
        // Check special characters are escaped
        $this->assertStringContainsString('&amp;', $xmlContent);
        $this->assertStringNotContainsString('PT. Test & Company', $xmlContent); // Raw ampersand should not exist
        
        // Verify XML is valid
        $xml = simplexml_load_string($xmlContent);
        $this->assertNotFalse($xml);
        
        // Clean up
        if (file_exists($result['filepath'])) {
            unlink($result['filepath']);
        }
    }

    /**
     * Test XML date format is correct
     */
    public function test_xml_date_format_is_correct()
    {
        $cv = CV::factory()->create();
        $customer = Customer::factory()->create();
        $product = Product::factory()->create();

        $selling = Selling::factory()->create([
            'cv_id' => $cv->id,
            'customer_id' => $customer->id,
            'date' => '2025-11-05 10:30:00'
        ]);

        SellingDetail::factory()->create([
            'selling_id' => $selling->id,
            'product_id' => $product->id
        ]);

        $result = $this->coretaxService->generateBulkInvoiceXML([$selling->id]);

        $xmlContent = file_get_contents($result['filepath']);
        
        // Check date format is YYYY-MM-DD
        $this->assertStringContainsString('<TaxInvoiceDate>2025-11-05</TaxInvoiceDate>', $xmlContent);
        
        // Clean up
        if (file_exists($result['filepath'])) {
            unlink($result['filepath']);
        }
    }

    /**
     * Test can access bulk export test page
     */
    public function test_can_access_bulk_export_test_page()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('selling.view');

        $response = $this->actingAs($user)->get(route('selling.coretax-bulk-export-page'));

        $response->assertOk();
        $response->assertViewIs('pages.backoffice.selling.coretax-bulk-export');
    }

    /**
     * Test cleanTin method formats NPWP correctly
     */
    public function test_clean_tin_formats_correctly()
    {
        $reflection = new \ReflectionClass($this->coretaxService);
        $method = $reflection->getMethod('cleanTin');
        $method->setAccessible(true);

        // Test with formatted NPWP
        $result = $method->invokeArgs($this->coretaxService, ['08.300.441.0-361.300']);
        $this->assertEquals('083004410361300', $result);

        // Test with unformatted NPWP
        $result = $method->invokeArgs($this->coretaxService, ['083004410361300']);
        $this->assertEquals('083004410361300', $result);

        // Test with short NPWP (should pad)
        $result = $method->invokeArgs($this->coretaxService, ['12345']);
        $this->assertEquals('000000000012345', $result);

        // Test with special characters
        $result = $method->invokeArgs($this->coretaxService, ['08-300-441-0-361-300']);
        $this->assertEquals('083004410361300', $result);
    }

    /**
     * Test VAT calculation is correct
     */
    public function test_vat_calculation_is_correct()
    {
        $cv = CV::factory()->create();
        $customer = Customer::factory()->create();
        $product = Product::factory()->create();

        $selling = Selling::factory()->create([
            'cv_id' => $cv->id,
            'customer_id' => $customer->id
        ]);

        $subtotal = 10000000;
        SellingDetail::factory()->create([
            'selling_id' => $selling->id,
            'product_id' => $product->id,
            'price_sell' => 1000,
            'total_qty' => 10000,
            'subtotal' => $subtotal
        ]);

        $result = $this->coretaxService->generateBulkInvoiceXML([$selling->id]);

        $xmlContent = file_get_contents($result['filepath']);
        
        // Expected VAT: 10,000,000 * 12% = 1,200,000
        $expectedVat = number_format($subtotal * 0.12, 2, '.', '');
        $this->assertStringContainsString("<VAT>{$expectedVat}</VAT>", $xmlContent);
        $this->assertStringContainsString('<VATRate>12</VATRate>', $xmlContent);
        
        // Clean up
        if (file_exists($result['filepath'])) {
            unlink($result['filepath']);
        }
    }
}
