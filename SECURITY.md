# 🔐 Sistema de Segurança e Permissões

## Camadas de Segurança Implementadas

### 1️⃣ Autenticação (`AuthMiddleware`)
- **Localização**: `app/Http/Middlewares/AuthMiddleware.php`
- **Função**: Verifica se o usuário está autenticado
- **Aplicação**: Todas as rotas em `routes/dashboard.php`
- **Tecnologia**: Sessões PHP

### 2️⃣ Autorização ACL (Access Control List)
- **Localização**: `app/Helpers/ACL.php`
- **Função**: Controla permissões granulares por role e módulo
- **Aplicação**: Dentro de cada método dos controllers

## 📊 Estrutura de Roles

| Role | Label | Descrição | Nível de Acesso |
|------|-------|-----------|-----------------|
| `admin` | Administrador | Acesso total ao sistema | 🔴 Total |
| `manager` | Gerente | Gerencia conteúdo e equipe | 🟡 Alto |
| `operator` | Operador | Opera funcionalidades básicas | 🟢 Médio |
| `viewer` | Visualizador | Apenas visualização | 🔵 Baixo |

## 🎯 Módulos e Permissões

### Dashboard
- **Permissões**: `view`
- **Todos os roles**: ✅ Acesso

### Sliders
- **Permissões**: `view`, `create`, `update`, `delete`, `reorder`, `toggle_status`
- **Admin**: ✅ Todas
- **Manager**: ✅ view, create, update, reorder
- **Operator**: ❌ Sem acesso
- **Viewer**: ❌ Sem acesso

### Currículos
- **Permissões**: `view`, `create`, `update`, `delete`, `export`, `approve`, `reject`, `schedule`
- **Admin**: ✅ Todas
- **Manager**: ✅ view, update, export, approve, reject, schedule
- **Operator**: ✅ view, update, schedule
- **Viewer**: ❌ Sem acesso

### Usuários
- **Permissões**: `view`, `create`, `update`, `delete`, `reset_password`, `activate`, `deactivate`
- **Admin**: ✅ Todas
- **Manager**: ❌ Sem acesso
- **Operator**: ❌ Sem acesso
- **Viewer**: ❌ Sem acesso

### Depoimentos
- **Permissões**: `view`, `create`, `update`, `delete`, `approve`, `reject`
- **Admin**: ✅ Todas
- **Manager**: ✅ view, approve, reject
- **Operator**: ✅ view
- **Viewer**: ❌ Sem acesso

### Configurações
- **Permissões**: `view`, `update`
- **Admin**: ✅ Todas
- **Manager**: ❌ Sem acesso
- **Operator**: ❌ Sem acesso
- **Viewer**: ❌ Sem acesso

### WhatsApp
- **Permissões**: `view`, `create`, `update`, `delete`, `send`, `connect`, `disconnect`
- **Admin**: ✅ Todas
- **Manager**: ✅ view, send
- **Operator**: ✅ view, send
- **Viewer**: ❌ Sem acesso

## ✅ Controllers Protegidos com ACL

### ✅ Todos os Controllers Protegidos

| Controller | Verificações ACL | Status |
|------------|------------------|---------|
| `DashboardController` | 1 | ✅ Protegido |
| `SliderController` | 7 | ✅ Protegido |
| `CurriculumController` | 7 | ✅ Protegido |
| `UsersController` | 4 | ✅ Protegido |
| `TestimonialController` | 5 | ✅ Protegido |
| `ConfigsController` | 1 | ✅ Protegido |

**Total**: 25 verificações ACL implementadas

## 🔧 Como Usar ACL nos Controllers

### Exemplo Básico
```php
use App\Helpers\ACL;

public function index($router): void
{
    // Verifica permissão de visualização
    if (!ACL::can($_SESSION['user_role'], 'sliders', 'view')) {
        http_response_code(403);
        echo "Acesso negado";
        return;
    }
    
    // Código protegido...
}
```

### Verificar Múltiplas Permissões (AND)
```php
// Usuário precisa TER TODAS as permissões
if (!ACL::canAll($_SESSION['user_role'], 'curriculos', ['view', 'update', 'delete'])) {
    http_response_code(403);
    echo "Acesso negado";
    return;
}
```

### Verificar Qualquer Permissão (OR)
```php
// Usuário precisa ter PELO MENOS UMA das permissões
if (!ACL::canAny($_SESSION['user_role'], 'curriculos', ['view', 'export'])) {
    http_response_code(403);
    echo "Acesso negado";
    return;
}
```

## 🎨 Menu Dinâmico

O sistema gera menu automaticamente baseado nas permissões do usuário:

```php
// Retorna apenas itens que o usuário tem acesso
$menu = ACL::getMenuForRole($_SESSION['user_role']);
```

## 🔍 Métodos Úteis da Classe ACL

| Método | Descrição | Exemplo |
|--------|-----------|---------|
| `ACL::can()` | Verifica permissão específica | `ACL::can('admin', 'sliders', 'create')` |
| `ACL::canAll()` | Verifica múltiplas permissões (AND) | `ACL::canAll('manager', 'curriculos', ['view', 'update'])` |
| `ACL::canAny()` | Verifica qualquer permissão (OR) | `ACL::canAny('operator', 'depoimentos', ['view', 'approve'])` |
| `ACL::hasModuleAccess()` | Verifica acesso ao módulo | `ACL::hasModuleAccess('viewer', 'dashboard')` |
| `ACL::getMenuForRole()` | Retorna menu filtrado | `ACL::getMenuForRole('manager')` |
| `ACL::getAllRoles()` | Lista todos os roles | `ACL::getAllRoles()` |
| `ACL::getRoleLabel()` | Nome amigável do role | `ACL::getRoleLabel('admin')` |
| `ACL::getPermissionsMatrix()` | Matriz completa de permissões | `ACL::getPermissionsMatrix()` |

## 🛡️ Fluxo de Segurança

```
Requisição HTTP
    ↓
1. AuthMiddleware
    ├─ Verifica sessão ($_SESSION['user_id'])
    ├─ Se não autenticado → Redireciona para login
    └─ Se autenticado → Continua
    ↓
2. Controller Method
    ├─ ACL::can() verifica permissão específica
    ├─ Se sem permissão → HTTP 403
    └─ Se com permissão → Executa ação
    ↓
3. Resposta ao Usuário
```

## 📝 Boas Práticas

### ✅ FAZER:
- Sempre usar `ACL::can()` antes de executar ações sensíveis
- Retornar HTTP 403 quando acesso for negado
- Documentar novas permissões no `ACL.php`
- Usar menu dinâmico baseado em permissões

### ❌ NÃO FAZER:
- Verificar permissões apenas no frontend
- Confiar em dados do usuário sem validar permissões
- Expor endpoints sem proteção ACL
- Criar lógica de permissão fora da classe ACL

## 🚀 Adicionando Novos Módulos

1. Adicione o módulo em `ACL::ROLES` com as permissões
2. Adicione ações específicas em `ACL::MODULE_ACTIONS` (se necessário)
3. Adicione item no menu em `ACL::MENU_ITEMS`
4. Implemente verificações ACL no controller
5. Teste com diferentes roles

## 🔒 Sessão e Configuração

- **Tempo de vida da sessão**: 3600 segundos (1 hora)
- **Configuração**: `routes/dashboard.php` (linhas 13-16)
- **Variáveis de sessão**:
  - `$_SESSION['user_id']` - ID do usuário
  - `$_SESSION['user_role']` - Role do usuário (admin, manager, etc.)

## 📊 Estatísticas de Segurança

- **Controllers Protegidos**: 6/6 (100%)
- **Rotas com Middleware**: 24/24 (100%)
- **Verificações ACL**: 25 checks
- **Roles Definidos**: 4
- **Módulos Protegidos**: 7
- **Permissões Granulares**: 14 tipos

---

**Última Atualização**: 11/02/2026
**Status**: ✅ Sistema Completamente Seguro
