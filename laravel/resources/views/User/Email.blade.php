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
        <p style="font-size: 16px; margin-bottom: 20px;">Olá {{$contentData['nome']}},

            Obrigado por se juntar à nossa plataforma! Para ativar a sua conta, por favor utilize o código de ativação abaixo:
        </p>
        <p style="font-size: 16px; margin-bottom: 20px;">    Código de Ativação: {{$contentData['mensagem']}} </p>

        <p style="font-size: 16px; margin-bottom: 20px;">     Por favor, insira este código na página de ativação da sua conta. Se tiver alguma dúvida ou precisar de assistência, não hesite em contactar-nos.
        </p>
        <p style="font-size: 16px; margin-bottom: 20px;">
            Bem-vindo e esperamos que tenha uma ótima experiência na nossa plataforma!
        </p>
        <p style="font-size: 16px; margin-bottom: 20px;">
            Cumprimentos,
        </p>
        <p style="font-size: 16px; margin-bottom: 20px;">
            Alojamento de ESTGOH</p>

    </div>
</div>
</body>
</html>
