<?php

$data = [
    "request_sipo" => [
        "caso" => [
            "declaracion" =>
                "Al entrar a mi casa me distraje por un segundo mientras daba reversa golpee un muro del parqueadero dañando el stop izquierdo trasero y lamentablemente al tratar de mover el vehículo para minimizar el daño golpee la farola izquierda delantera con la puerta de entrada al parqueadero.",
            "sistemaLiberty" => "A",
            "fechaSiniestro" => "2022-07-13T08: 30: 00.Z",
            "numeroSiniestroiAxis" => "936225",
        ],
        "vehiculo" => [
            "placa" => "HPO337",
            "marca" => "NISSAN",
            "ciudadReparacion" => "76001",
            "ramo" => 900753,
            "modelo" => 2014,
            "tipoVehiculo" => "L",
            "empresaAfiliadora" => "",
            "banco" => false,
            "taxi" => false,
            "amparo" => "PERDIDA PARCIAL DAu00d1OS",
            "placaTercero" => "",
            "vin" => "",
            "estadoVehiculo" => "Movilizado",
            "poliza" => "418025",
            "taller" => 7223,
            "blindado" => false,
            "recobros" => false,
            "valorComercial" => 0,
            "valorAsegurado" => 0,
            "servicio" => "Particular",
            "pais" => 1,
        ],
        "asegurado" => [
            "nombre" => "LINA EUCARIS RIVAS ",
            "celular" => "3137030079",
            "email" => "ESTEFIS1512@HOTMAIL.COM",
            "telefono" => "3137030079",
        ],
        "conductor" => [
            "nombre" => "Estefania Cuellar Rivas",
            "celular" => "3137030079",
            "cedula" => "1144037940",
            "email" => "ESTEFIS1512@HOTMAIL.COM",
            "telefono" => "3137030079",
            "direccion" => " VI/ VI KR 89 18 61 CA 12 VILLAS DE SAN JUAQUIN ",
        ],
        "declarante" => [
            "tipo" => "Asegurado",
            "nombre" => "Estefanía Cuellar Rivas",
            "identificacion" => "1144037940",
            "departamentoCirculacion" => "76",
            "ciudadCirculacion" => "76001",
            "fechaDeclaracion" => "2022-07-15T02: 07:49.Z",
            "fechaAviso" => "2022-07-15T02: 07:49.Z",
            "telefono" => "3137030079",
            "celular" => "3137030079",
            "email" => "ESTEFIS1512@HOTMAIL.COM",
            "direccion" => " VI/ VI KR 89 18 61 CA 12 VILLAS DE SAN JUAQUIN ",
        ],
    ],
    "timestamp" => 1657868869,
    "token" => "Q5AlhAETXRlEzPW5u30K7_7MMCiTfERE1forRoxztHcHPO337",
];
$date = date('d/m/Y', $data['timestamp']);

 $body = 'Buen dia, 

        Al momento de crear el siniestro  en sipo  el flujo de asegurado hubo un error, la información relevante para su creación manual es: 

        Numero de caso  de iaxis: ' . $data['request_sipo']['caso']['numeroSiniestroiAxis'] . ' 
        Datos del asegurado: ' . $data['request_sipo']['asegurado']['nombre'] . ' 
        Placa: ' . $data['request_sipo']['vehiculo']['placa'] . ' 
        Taller Escogido:  ' . $data['request_sipo']['vehiculo']['taller'] . ' 
        Fecha  de la creación del siniestro: ' . $date . ' 
        Numero Celular: ' . $data['request_sipo']['asegurado']['celular'] . ' 
        Correo: ' . $data['request_sipo']['asegurado']['email'].'
        
        Enviado desde el portal Liberty Seguros Colombia';
echo nl2br($body);