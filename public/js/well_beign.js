document.addEventListener('DOMContentLoaded', function () {
    const wellBeignTrue = document.getElementById('pregunta_1_si');
    const wellBeignFalse = document.getElementById('pregunta_1_no');

    const wellBeignTrue2 = document.getElementById('pregunta_2_si');
    const wellBeignFalse2 = document.getElementById('pregunta_2_no');

    const wellBeignTrue3 = document.getElementById('pregunta_3_si');
    const wellBeignFalse3 = document.getElementById('pregunta_3_no');

    const wellBeignTrue4 = document.getElementById('pregunta_4_si');
    const wellBeignFalse4 = document.getElementById('pregunta_4_no');


    wellBeignTrue.addEventListener('change', function () {
        if (wellBeignTrue.checked) {
            $("#razon_pregunta_1").show();
        }
    });

    wellBeignFalse.addEventListener('change', function () {
        if (wellBeignFalse.checked) {
            $("#razon_pregunta_1").hide();
        }
    });

    wellBeignTrue2.addEventListener('change', function () {
        if (wellBeignTrue2.checked) {
            $("#razon_pregunta_2").show();
        }
    });

    wellBeignFalse2.addEventListener('change', function () {
        if (wellBeignFalse2.checked) {
            $("#razon_pregunta_2").hide();
        }
    });

    wellBeignTrue3.addEventListener('change', function () {
        if (wellBeignTrue3.checked) {
            $("#razon_pregunta_3").show();
        }
    });

    wellBeignFalse3.addEventListener('change', function () {
        if (wellBeignFalse3.checked) {
            $("#razon_pregunta_3").hide();
        }
    });

    wellBeignTrue4.addEventListener('change', function () {
        if (wellBeignTrue4.checked) {
            $("#razon_pregunta_4").show();
        }
    });

    wellBeignFalse4.addEventListener('change', function () {
        if (wellBeignFalse4.checked) {
            $("#razon_pregunta_4").hide();
        }
    });
});