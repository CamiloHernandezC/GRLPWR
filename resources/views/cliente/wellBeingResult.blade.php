<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Valoración Física</title>
    <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f0f4f8;
                color: #333;
                margin: 0;
                padding: 0;
            }

            header {
                background-color: #2a9d8f;
                color: white;
                padding: 20px;
                text-align: center;
            }

            .container {
                max-width: 900px;
                margin: 20px auto;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .section-title {
                font-size: 1.5em;
                color: #264653;
                margin-bottom: 10px;
            }

            .data, .results {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .data div, .results div {
                width: 48%;
                margin-bottom: 15px;
            }

            .data div p, .results div p {
                margin: 5px 0;
            }

            .highlight {
                font-weight: bold;
                color: #e76f51;
            }

            .test {
                background-color: #e9ecef;
                padding: 10px;
                border-radius: 8px;
                margin-bottom: 15px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Aplicar sombra también aquí */
            }

            footer {
                text-align: center;
                margin-top: 20px;
                padding: 10px;
                background-color: #2a9d8f;
                color: white;
            }
    </style>
</head>

<body>

<header>
    <h1>Resultados de Valoración Física</h1>
    <p>Informe detallado de la prueba realizada</p>
</header>

<div class="container">
    <!-- Datos Básicos -->
    <section>
        <h2 class="section-title">Datos Básicos</h2>
        <div class="data">
            <div>
                <p><span class="highlight">Nombre:</span> Juan Pérez</p>
                <p><span class="highlight">Edad:</span> 30 años</p>
                <p><span class="highlight">Género:</span> Masculino</p>
            </div>
            <div>
                <p><span class="highlight">Altura:</span> 1.75 m</p>
                <p><span class="highlight">Peso:</span> 70 kg</p>
                <p><span class="highlight">Fecha de prueba:</span> 04/10/2024</p>
            </div>
        </div>
    </section>

    <!-- Resultados de Fuerza -->
    <section>
        <h2 class="section-title">Resultados de Pruebas de Fuerza</h2>
        <div class="results">
            <div class="test">
                <p><span class="highlight">Abdominales:</span> 45 repeticiones en 1 minuto</p>
            </div>
            <div class="test">
                <p><span class="highlight">Flexiones de pecho:</span> 30 repeticiones en 1 minuto</p>
            </div>
            <div class="test">
                <p><span class="highlight">Sentadillas:</span> 40 repeticiones en 1 minuto</p>
            </div>
        </div>
    </section>

    <!-- Prueba de Flexibilidad -->
    <section>
        <h2 class="section-title">Prueba de Flexibilidad</h2>
        <div class="test">
            <p><span class="highlight">Flexibilidad:</span> 12 cm</p>
        </div>
    </section>

    <!-- Test de Ledger -->
    <section>
        <h2 class="section-title">Test de Ledger</h2>
        <div class="test">
            <p><span class="highlight">Resultado:</span> 15 puntos</p>
        </div>
    </section>

    <!-- Medidas Corporales -->
    <section>
        <h2 class="section-title">Medidas Corporales</h2>
        <div class="results">
            <div class="test">
                <p><span class="highlight">Índice de Masa Corporal (IMC):</span> 22.9</p>
            </div>
            <div class="test">
                <p><span class="highlight">Edad del cuerpo:</span> 28 años</p>
            </div>
            <div class="test">
                <p><span class="highlight">Masa muscular:</span> 35%</p>
            </div>
            <div class="test">
                <p><span class="highlight">Grasa corporal:</span> 20%</p>
            </div>
            <div class="test">
                <p><span class="highlight">Grasa visceral:</span> 8%</p>
            </div>
        </div>
    </section>
</div>

<footer>
    <p>&copy; 2024 Valoración Física - Todos los derechos reservados</p>
</footer>

</body>

</html>
