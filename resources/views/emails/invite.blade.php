<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Convite</title>
</head>
<body>
    <center><img src="http://www.pointscontrol.com/img/logo.png" class="logo" alt="POINTS Control Logo"><br></center>
    <center><h1>Você foi convidado para o POINTS Control!</h1></center>
    <p>No POINTS Control você terá acesso a ferramenta mais moderna para administração dos seus pontos, acúmulos e emissões. E mais novidades estão chegando!</p>
    <p>Clique no link abaixo para se cadastrar:</p>

    <center><a href="{{ url('/register?token=' . $token) }}" class="m_401382664036405901button" rel="noopener" style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';border-radius:4px;color:#fff;display:inline-block;overflow:hidden;text-decoration:none;background-color:#2d3748;border-bottom:8px solid #2d3748;border-left:18px solid #2d3748;border-right:18px solid #2d3748;border-top:8px solid #2d3748;word-break:break-all" target="_blank">Completar meu cadastro</a></center>

    <p>Caso você não tenha problemas com o link acima, copie e cole no seu navegador o endereço abaixo:</p>
    <p>{{ url('/register?token=' . $token) }}</p>
    <p>Se você não se cadastrou, por favor ignore este e-mail. Você não receberá novas notificações.</p>
</body>
</html>
