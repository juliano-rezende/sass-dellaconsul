# Estrutura de Rotas

Esta pasta contém todos os arquivos de rotas da aplicação, organizados por funcionalidade.

## Arquivos de Rotas

### 📄 `web.php`
**Rotas Públicas do Site**
- Não requerem autenticação
- Incluem: home, contatos, trabalhe conosco, páginas legais, etc.
- Namespace: `App\Http\Controllers\Site`

### 🔐 `auth.php`
**Rotas de Autenticação**
- Responsável por login e logout
- Namespace: `App\Http\Controllers`

### 🎛️ `dashboard.php`
**Rotas Protegidas do Dashboard**
- Todas requerem autenticação via `AuthMiddleware`
- Gerenciamento de: sliders, currículos, usuários, depoimentos, configurações
- Namespace: `App\Http\Controllers\Dashboard`
- **Nota**: Inicia a sessão automaticamente antes de carregar as rotas

### ⚠️ `errors.php`
**Rotas de Tratamento de Erros**
- Responsável por exibir páginas de erro
- Namespace: `App\Helpers`

## Como Funciona

O arquivo `index.php` na raiz do projeto carrega automaticamente todos os arquivos de rotas:

```php
$routeFiles = [
    __DIR__ . '/routes/web.php',
    __DIR__ . '/routes/auth.php',
    __DIR__ . '/routes/dashboard.php',
    __DIR__ . '/routes/errors.php',
];
```

Cada arquivo retorna uma função que recebe o objeto `$router` e registra as rotas correspondentes.

## Gerenciamento de Sessões

⚠️ **Importante**: A sessão (`session_start()`) agora é iniciada apenas no arquivo `dashboard.php`, ou seja, apenas para rotas que realmente precisam dela. Isso melhora a performance e segurança da aplicação.

## Adicionando Novas Rotas

### Para adicionar rotas públicas:
Edite o arquivo `routes/web.php`

### Para adicionar rotas protegidas:
Edite o arquivo `routes/dashboard.php`

### Para criar um novo grupo de rotas:
1. Crie um novo arquivo em `routes/`
2. Siga o padrão dos arquivos existentes
3. Adicione o caminho do arquivo no array `$routeFiles` do `index.php`
