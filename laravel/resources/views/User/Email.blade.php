<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alojamento Estgoh </title>
</head>
<body style="background-color: transparent; font-family: Arial, sans-serif; text-align: center; width: max-content">
<div style="text-align: center;">
    <div style="display: inline-block; max-width: 600px; padding: 40px; background-color: #ffffff; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); border-radius: 20px;">
        <h3 style="font-size: 24px; margin-bottom: 20px;">Verifique seu e-mail</h3>
        <img src="https://comum.rcaap.pt/retrieve/104938" style="display: block; margin: 0 auto; margin-bottom: 20px; width: 500px;">
        <p style="font-size: 16px; margin-bottom: 20px;">Estamos felizes por você estar aqui. Vamos verificar seu endereço de e-mail:</p>
        <div style="margin-bottom: 20px;">
            <a href="http://127.0.0.1:8000/validation" style="display: inline-block; padding: 10px 20px; background-color: #3B82F6; color: #ffffff; border-radius: 5px; text-decoration: none;">Clique para verificar e-mail</a>
        </div>
        <p style="font-size: 14px;">O seu código de verificação é: {{$contentData}}</p>

    </div>
</div>
</body>
</html>
