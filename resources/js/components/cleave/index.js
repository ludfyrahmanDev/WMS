(function () {
    "use strict";
    $(".input-price").each(function () {
        const el = this;
        new Cleave(el, {
            numeral: true,
            prefix: "Rp ",
            numeralThousandsGroupStyle: "thousand",
            numeralDecimalMark: ",",
            delimiter: ".",
        });
    });
    
})();
