(function () {
    "use strict";
    $(".input-price").each(function () {
        const el = this;
        new Cleave(el, {
            numeral: true,
            numeralThousandsGroupStyle: "thousand",
            numeralDecimalMark: ",",
            delimiter: ".",
        });
    });
    
})();
