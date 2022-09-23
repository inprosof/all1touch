<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/ * Mensagens de e-mail * /

// Verificação de conta
$ lang ['aauth_email_verification_subject'] = 'Verificação da conta';
$ lang ['aauth_email_verification_code'] = 'Seu código de verificação é:';
$ lang ['aauth_email_verification_text'] = "Você também pode clicar (ou copiar e colar) o seguinte link \ n \ n";

// Redefinição de senha
$ lang ['aauth_email_reset_subject'] = 'Redefinir senha';
$ lang ['aauth_email_reset_text'] = "Para redefinir sua senha, clique (ou copie e cole na barra de endereço do seu navegador) no link abaixo: \ n \ n";

// Sucesso na redefinição da senha
$ lang ['aauth_email_reset_success_subject'] = 'Redefinição de senha bem-sucedida';
$ lang ['aauth_email_reset_success_new_password'] = 'Sua senha foi redefinida com sucesso. Sua nova senha é: ';


/* Mensagens de erro */

// Erros de criação de conta
$ lang ['aauth_error_email_exists'] = 'Endereço de email já existe no sistema. Se você esqueceu sua senha, você pode clicar no link abaixo. ';
$ lang ['aauth_error_username_exists'] = "A conta já existe no sistema com este nome de utilizador. Por favor, digite um nome de utilizador diferente, ou se você esqueceu sua senha, clique no link abaixo.";
$ lang ['aauth_error_email_invalid'] = 'Endereço de e-mail inválido';
$ lang ['aauth_error_password_invalid'] = 'Senha inválida';
$ lang ['aauth_error_username_invalid'] = 'Nome de utilizador inválido';
$ lang ['aauth_error_username_required'] = 'Nome de utilizador obrigatório';
$ lang ['aauth_error_totp_code_required'] = 'Código de autenticação necessário';
$ lang ['aauth_error_totp_code_invalid'] = 'Código de autenticação inválido';


// Erros de atualização da conta
$ lang ['aauth_error_update_email_exists'] = 'Endereço de email já existe no sistema. Por favor, insira um endereço de e-mail diferente. ';
$ lang ['aauth_error_update_username_exists'] = "Nome de utilizador já existe no sistema. Por favor, digite um nome de utilizador diferente.";


// Erros de acesso
$ lang ['aauth_error_no_access'] = 'Desculpe, você não tem acesso ao recurso que solicitou.';
$ lang ['aauth_error_login_failed_email'] = 'Endereço de e-mail e senha não conferem.';
$ lang ['aauth_error_login_failed_name'] = 'Nome de utilizador e senha não conferem.';
$ lang ['aauth_error_login_failed_all'] = 'E-mail, nome de utilizador ou senha não conferem.';
$ lang ['aauth_error_login_attempts_exceeded'] = 'Você excedeu suas tentativas de login, sua conta foi bloqueada.';
$ lang ['aauth_error_recaptcha_not_correct'] = 'Desculpe, o texto reCAPTCHA inserido estava incorreto.';

// Misc. erros
$ lang ['aauth_error_no_user'] = 'Utilizador não existe';
$ lang ['aauth_error_account_not_verified'] = 'Sua conta não foi verificada. Por favor, verifique o seu e-mail e verifique a sua conta. ';
$ lang ['aauth_error_no_group'] = 'Grupo não existe';
$ lang ['aauth_error_no_subgroup'] = 'Subgrupo não existe';
$ lang ['aauth_error_self_pm'] = 'Não é possível enviar uma mensagem para você.';
$ lang ['aauth_error_no_pm'] = 'Mensagem privada não encontrada';


/ * Mensagens informativas * /
$ lang ['aauth_info_already_member'] = 'O utilizador já é membro do grupo';
$ lang ['aauth_info_already_subgroup'] = 'Subgrupo já é membro do grupo';
$ lang ['aauth_info_group_exists'] = 'O nome do grupo já existe';
$ lang ['aauth_info_perm_exists'] = 'O nome da permissão já existe';
