<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['email_must_be_array'] = 'O método de validação de e-mail deve receber um array.';
$lang['email_invalid_address'] = 'Endereço de e-mail inválido: %s';
$lang['email_attachment_missing'] = 'Não foi possível localizar o seguinte anexo de e-mail: %s';
$lang['email_attachment_unreadable'] = 'Não foi possível abrir este anexo: %s';
$lang['email_no_from'] = 'Não é possível enviar e-mail sem o cabeçalho "De".';
$lang['email_no_recipients'] = 'Você deve incluir destinatários: Para, Cc ou Cco';
$lang['email_send_failure_phpmail'] = 'Não foi possível enviar e-mail usando PHP mail(). Seu servidor pode não estar configurado para enviar correio usando este método.';
$lang['email_send_failure_sendmail'] = 'Não foi possível enviar e-mail usando PHP Sendmail. Seu servidor pode não estar configurado para enviar correio usando este método.';
$lang['email_send_failure_smtp'] = 'Não foi possível enviar e-mail usando PHP SMTP. Seu servidor pode não estar configurado para enviar correio usando este método.';
$lang['email_sent'] = 'Sua mensagem foi enviada com sucesso usando o seguinte protocolo: %s';
$lang['email_no_socket'] = 'Não foi possível abrir um socket para Sendmail. Por favor, verifique as configurações.';
$lang['email_no_hostname'] = 'Você não especificou um nome de host SMTP.';
$lang['email_smtp_error'] = 'O seguinte erro SMTP foi encontrado: %s';
$lang['email_no_smtp_unpw'] = 'Erro: Você deve atribuir um nome de utilizador e senha SMTP.';
$lang['email_failed_smtp_login'] = 'Falha ao enviar o comando AUTH LOGIN. Erro: %s';
$lang['email_smtp_auth_un'] = 'Falha ao autenticar o nome de utilizador. Erro: %s';
$lang['email_smtp_auth_pw'] = 'Falha ao autenticar a senha. Erro: %s';
$lang['email_smtp_data_failure'] = 'Não foi possível enviar dados: %s';
$lang['email_exit_status'] = 'Código de status de saída: %s';
