<?php

namespace Tests\Feature;

use Tests\TestCase;




class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /*public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }*/


    /*public function testBasicTest2()
    {
        $response1 = $this->get('/');
        $response1->assertStatus(200);
        $enlace = $driver->findElement(WebDriverBy::xpath('//a[@href="http://ejemplo.com"]'));


        // Realiza una solicitud GET para obtener la vista de registro
        $response = $this->get('/register');

        // Extrae el token CSRF del formulario
        $body = (string) $response->getContent();
        $token = $this->extractCsrfToken($body);

        // Envía una solicitud POST con los datos del formulario
        $dataArray = [
            '_token' => $token,
            'nombre' => 'Nombre de usuario',
            'telefono' => '1299567890',
            'clave' => 'contraseña',
            'correo' => 'correo@example.com'
        ];

// Convertir el array a una cadena JSON
        $dataJson = json_encode($dataArray);
        $response = $this->post('/register', [
            'body' => $dataJson

        ]);
        $response->assertStatus(302);


    }

    private function extractCsrfToken($html)
    {
        preg_match('/<input type="hidden" name="_token" value="([^"]+)"/', $html, $matches);
        return $matches[1] ?? null;
    }

}*/
}