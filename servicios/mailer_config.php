<?php
/**
 * CONFIGURACIÓN DE PHPMAILER
 * ============================
 * Este archivo centraliza toda la configuración de envío de correos
 * 
 * IMPORTANTE: Reemplaza los valores con tus propias credenciales
 */

// ========== CONFIGURACIÓN SMTP ==========
define("MAIL_HOST", "smtp.gmail.com");
define("MAIL_USERNAME", "alvaroortega914@gmail.com");           // <-- CAMBIA ESTO
define("MAIL_PASSWORD", "bxjmhjpapdmvxlri");      // <-- CAMBIA ESTO
define("MAIL_SECURE", "tls");                              // 'tls' o 'ssl'
define("MAIL_PORT", 587);                                  // 587 para TLS, 465 para SSL

// ========== CONFIGURACIÓN DEL REMITENTE ==========
define("MAIL_FROM_ADDRESS", "alvaroortega914@gmail.com");        // <-- CAMBIA ESTO
define("MAIL_FROM_NAME", "Sistema de Gestión Escolar");

// ========== CONFIGURACIÓN GENERAL ==========
define("URL_SISTEMA", "http://localhost/IGS_2/");
define("DEBUG_MAIL", false);                               // Cambiar a true para ver errores detallados

?>
