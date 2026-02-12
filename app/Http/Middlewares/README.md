# Middlewares da Aplicação

Este diretório contém os middlewares utilizados para interceptar e processar requisições HTTP.

## 📋 Índice

1. [SessionMiddleware](#sessionmiddleware)
2. [AuthMiddleware](#authmiddleware)
3. [Ordem de Execução](#ordem-de-execução)
4. [Debug e Monitoramento](#debug-e-monitoramento)

---

## 🔄 SessionMiddleware

### Responsabilidades

O `SessionMiddleware` gerencia o ciclo de vida completo das sessões com foco em segurança:

- ✅ Inicialização de sessões com parâmetros seguros
- ✅ Regeneração periódica de `session_id` (prevenção de session fixation)
- ✅ Validação de IP e User-Agent (prevenção de session hijacking)
- ✅ Timeout de inatividade (30 minutos)
- ✅ Configuração de cookies com flags de segurança
- ✅ Logging de eventos de segurança

### Configurações de Segurança

```php
// Cookie de sessão
HttpOnly: true          // Previne acesso via JavaScript (XSS)
Secure: true           // Apenas HTTPS (ajuste conforme ambiente)
SameSite: Strict       // Proteção CSRF

// Timeouts
Inatividade: 30 minutos (1800s)
Regeneração: 15 minutos (900s)
Vida máxima: 1 hora (3600s)
```

### Validações Implementadas

#### 1. **Validação de IP**
```php
// Detecta mudança de IP durante a sessão
// Considera proxies e load balancers
Headers verificados:
- HTTP_CF_CONNECTING_IP (Cloudflare)
- HTTP_X_REAL_IP (Nginx)
- HTTP_X_FORWARDED_FOR (Proxy)
- REMOTE_ADDR (Direto)
```

#### 2. **Validação de User-Agent**
```php
// Detecta mudança de navegador/dispositivo
// Previne session hijacking
```

#### 3. **Timeout de Inatividade**
```php
// 30 minutos sem atividade = sessão expirada
// Redireciona para login?timeout=1
```

#### 4. **Regeneração de Session ID**
```php
// A cada 15 minutos
// Previne session fixation attacks
```

### Eventos de Segurança Logados

O middleware registra os seguintes eventos no log de erro do PHP:

```
[SECURITY ALERT] IP mismatch detected | IP: x.x.x.x | ...
[SECURITY ALERT] User-Agent mismatch detected | ...
[SECURITY ALERT] Session lifetime exceeded | ...
[SECURITY ALERT] Session timeout - inactive for Xs | ...
```

⚠️ **Importante**: Estes logs devem ser monitorados em produção!

---

## 🔐 AuthMiddleware

### Responsabilidades

O `AuthMiddleware` verifica autenticação e permissões ACL:

- ✅ Valida se usuário está autenticado
- ✅ Extrai módulo da URL
- ✅ Verifica permissões de acesso via ACL
- ✅ Redireciona para login se não autenticado
- ✅ Retorna erro 403 se sem permissão

### Fluxo de Validação

```
Request → SessionMiddleware → AuthMiddleware → Controller
           │                   │
           ├─ Valida sessão   ├─ Verifica login
           ├─ Regenera ID     ├─ Valida ACL
           └─ Timeout check   └─ 403 ou OK
```

---

## 🔄 Ordem de Execução

### Dashboard Routes

```php
// routes/dashboard.php

1. SessionMiddleware::handle()
   ↓
2. AuthMiddleware::handle()
   ↓
3. Controller::method()
```

**Importante**: `SessionMiddleware` DEVE ser executado ANTES de `AuthMiddleware`!

### Outras Routes

```php
// routes/web.php, routes/auth.php
// SessionMiddleware NÃO é aplicado automaticamente
// Apenas AuthController inicia sessão quando necessário
```

---

## 🐛 Debug e Monitoramento

### 1. Ver Informações da Sessão Atual

```php
// Em qualquer controller ou view
$sessionInfo = \App\Http\Middlewares\SessionMiddleware::getSessionInfo();
var_dump($sessionInfo);

/* Retorna:
[
    'session_id' => 'abc123...',
    'session_name' => 'DELLACONSUL_SID',
    'created_at' => 1234567890,
    'last_activity' => 1234567890,
    'last_regeneration' => 1234567890,
    'user_ip' => '192.168.1.1',
    'user_id' => 1,
    'is_authenticated' => true
]
*/
```

### 2. Monitorar Logs de Segurança

```bash
# Tail dos logs em tempo real
tail -f /var/log/php_errors.log | grep "SECURITY ALERT"

# Contar eventos de segurança por tipo
grep "SECURITY ALERT" /var/log/php_errors.log | \
  cut -d']' -f2 | cut -d'|' -f1 | sort | uniq -c
```

### 3. Logs de Atividade (Development)

Em ambiente de desenvolvimento, o middleware também loga atividades normais:

```
[Session Activity] User: 1 | IP: 192.168.1.1 | Message: Session ID regenerated
```

Para desabilitar em produção, ajuste:
```php
if (getenv('APP_ENV') === 'development') {
    // Logs apenas em dev
}
```

---

## ⚙️ Configurações Personalizadas

### Ajustar Timeouts

Edite as constantes em `SessionMiddleware.php`:

```php
private const INACTIVITY_TIMEOUT = 1800;      // 30 minutos
private const REGENERATION_INTERVAL = 900;    // 15 minutos
private const SESSION_LIFETIME = 3600;        // 1 hora
```

### Desabilitar Validação de IP (Útil em Proxies)

Se sua infraestrutura usa proxies dinâmicos:

```php
// Em validateSession()
// Comente a validação de IP:
/*
if (!$this->validateIP()) {
    $this->logSecurityEvent('IP mismatch detected');
    return false;
}
*/
```

### Ajustar Cookies para HTTP (Desenvolvimento)

```php
// Em initializeSession()
// Para desenvolvimento local sem HTTPS:
ini_set('session.cookie_secure', '0');  // Permite HTTP
```

---

## 🔒 Boas Práticas de Segurança

### ✅ Fazer

- ✅ Sempre use HTTPS em produção
- ✅ Monitore logs de segurança
- ✅ Configure alertas para eventos críticos
- ✅ Teste regeneração de session_id
- ✅ Valide timeout em diferentes dispositivos

### ❌ Não Fazer

- ❌ Não armazene dados sensíveis na sessão sem criptografia
- ❌ Não desabilite validações sem entender o impacto
- ❌ Não ignore logs de segurança
- ❌ Não use HTTP em produção
- ❌ Não aumente timeouts sem necessidade

---

## 📊 Integração com Sistemas de Alertas

### Exemplo: Enviar Alertas para Slack

```php
// Em logSecurityEvent()
private function logSecurityEvent(string $message): void
{
    // ... código existente ...
    
    // Integração com Slack
    if (getenv('SLACK_WEBHOOK_URL')) {
        $this->sendSlackAlert($message);
    }
}

private function sendSlackAlert(string $message): void
{
    $payload = json_encode([
        'text' => '🚨 Security Alert: ' . $message,
        'username' => 'SessionMiddleware',
        'icon_emoji' => ':warning:'
    ]);
    
    $ch = curl_init(getenv('SLACK_WEBHOOK_URL'));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}
```

---

## 🧪 Testando o Middleware

### Teste 1: Timeout de Inatividade

```bash
# 1. Login normal
# 2. Aguarde 31 minutos
# 3. Tente acessar /dashboard
# Resultado esperado: Redireciona para /login?timeout=1
```

### Teste 2: Validação de IP

```bash
# Simular mudança de IP (requer acesso ao servidor)
# 1. Login normal
# 2. Force mudança de $_SERVER['REMOTE_ADDR']
# 3. Próxima requisição
# Resultado esperado: Sessão destruída, log de segurança gerado
```

### Teste 3: Regeneração de Session ID

```bash
# 1. Login normal
# 2. Anote session_id: echo session_id()
# 3. Aguarde 16 minutos
# 4. Próxima requisição
# 5. Verifique novo session_id
# Resultado esperado: ID diferente do anterior
```

---

## 📚 Referências

- [OWASP Session Management Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Session_Management_Cheat_Sheet.html)
- [PHP Session Security](https://www.php.net/manual/en/session.security.php)
- [Lei Geral de Proteção de Dados (LGPD)](https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2018/lei/l13709.htm)

---

**Última atualização**: 11 de Fevereiro de 2026
