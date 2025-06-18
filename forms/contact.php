<?php
/**
 * Script de Contato Simplificado
 * Não requer bibliotecas externas.
 */

// Garante que o script só execute ao receber dados do formulário (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ===== CONFIGURAÇÃO =====
    // Coloque aqui o seu e-mail que receberá as mensagens
    $receiving_email_address = 'limpattack@gmail.com';
    // ========================

    // Pega os dados do formulário e remove espaços em branco extras
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Validação simples para garantir que os campos não estão vazios e o e-mail é válido
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Envia um código de erro de volta ao navegador se a validação falhar
        http_response_code(400);
        echo "Por favor, preencha todos os campos e forneça um email válido.";
        exit;
    }

    // Monta o corpo do e-mail de forma legível
    $email_content = "Você recebeu uma nova mensagem do formulário de contato:\n\n";
    $email_content .= "Nome: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Assunto: $subject\n\n";
    $email_content .= "Mensagem:\n$message\n";

    // Monta os cabeçalhos do e-mail. Essencial para o funcionamento correto do "Responder"
    $email_headers = "From: $name <$email>\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    $email_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Tenta enviar o e-mail usando a função mail() do PHP
    if (mail($receiving_email_address, $subject, $email_content, $email_headers)) {
        // Se o envio for bem-sucedido, envia um código de sucesso
        http_response_code(200);
        echo "Obrigado! Sua mensagem foi enviada.";
    } else {
        // Se houver uma falha no servidor, envia um código de erro
        http_response_code(500);
        echo "Oops! Algo deu errado no servidor e não conseguimos enviar sua mensagem.";
    }

} else {
    // Se alguém tentar acessar o arquivo diretamente, nega o acesso
    http_response_code(403);
    echo "Houve um problema com sua solicitação. Por favor, tente novamente.";
}
?>