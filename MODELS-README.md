# Sistema de Models Active Record

Sistema completo de Models implementado com **Active Record Pattern** usando **Doctrine DBAL**, similar ao Laravel Eloquent.

## 📁 Estrutura de Arquivos

```
app/
├── Models/
│   ├── BaseModel.php          # Classe base abstrata
│   ├── User.php               # Model de usuário
│   ├── Slider.php             # Model de slider
│   ├── Curriculum.php         # Model de currículo
│   └── CareerArea.php         # Model de área de carreira
├── Traits/
│   ├── HasTimestamps.php      # Timestamps automáticos
│   ├── SoftDeletes.php        # Soft deletes
│   └── HasRelationships.php   # Relacionamentos
├── Support/
│   └── Validator.php          # Sistema de validação
└── Events/
    └── ModelEvent.php         # Sistema de eventos
```

## 🚀 Recursos Implementados

✅ **CRUD Completo** - Create, Read, Update, Delete  
✅ **Query Builder Fluente** - where, orderBy, limit, offset, etc.  
✅ **Timestamps Automáticos** - created_at, updated_at  
✅ **Soft Deletes** - deleted_at ao invés de deletar  
✅ **Relacionamentos** - hasMany, belongsTo, hasOne  
✅ **Validação Automática** - Regras de validação nos models  
✅ **Query Scopes** - Métodos reutilizáveis (ex: User::active())  
✅ **Events/Hooks** - beforeSave, afterSave, beforeDelete, etc.  
✅ **Mass Assignment Protection** - $fillable e $guarded  
✅ **Type Casting** - Conversão automática de tipos  

## 📖 Guia de Uso

### 1. CRUD Básico

#### Create (Criar)

```php
use App\Models\User;

// Método 1: Instanciar e salvar
$user = new User();
$user->name = 'João Silva';
$user->email = 'joao@email.com';
$user->password = '123456'; // Hash automático
$user->role = 'admin';
$user->save();

// Método 2: Create estático
$user = User::create([
    'name' => 'João Silva',
    'email' => 'joao@email.com',
    'password' => '123456',
    'role' => 'admin',
    'department' => 'ti',
    'status' => 'active'
]);
```

#### Read (Ler)

```php
// Buscar por ID
$user = User::findById(1);

// Buscar todos
$users = User::all();

// Buscar com condições
$user = User::where('email', 'joao@email.com')->first();

// Buscar múltiplos
$admins = User::where('role', 'admin')->get();
```

#### Update (Atualizar)

```php
$user = User::findById(1);
$user->name = 'João Santos';
$user->email = 'joao.santos@email.com';
$user->save();
```

#### Delete (Deletar)

```php
$user = User::findById(1);
$user->delete(); // Soft delete (marca deleted_at)

// Deletar permanentemente
$user->forceDelete();
```

### 2. Query Builder

```php
// Where simples
$users = User::where('status', 'active')->get();

// Múltiplos wheres
$users = User::where('status', 'active')
             ->where('role', 'admin')
             ->get();

// Order by
$users = User::orderBy('name', 'ASC')->get();

// Limit e Offset (paginação)
$users = User::orderBy('created_at', 'DESC')
             ->limit(10)
             ->offset(0)
             ->get();

// Count
$total = User::where('status', 'active')->count();

// Select específico
$users = User::select('id', 'name', 'email')->get();

// Combinando tudo
$users = User::where('status', 'active')
             ->where('role', 'admin')
             ->orderBy('name', 'ASC')
             ->limit(10)
             ->get();
```

### 3. Query Scopes

Query Scopes são métodos reutilizáveis nos Models:

```php
// No Model User.php
public function scopeActive($query): self
{
    return $this->where('status', 'active');
}

public function scopeByRole($query, string $role): self
{
    return $this->where('role', $role);
}

// Uso
$activeUsers = User::active()->get();
$activeAdmins = User::active()->byRole('admin')->get();
```

### 4. Relacionamentos

#### HasMany (Um para Muitos)

```php
// No Model CareerArea
public function curriculums(): array
{
    return $this->hasMany(Curriculum::class, 'career_area_id');
}

// Uso
$area = CareerArea::findById(1);
$curriculums = $area->curriculums();
```

#### BelongsTo (Muitos para Um)

```php
// No Model Curriculum
public function careerArea(): ?object
{
    return $this->belongsTo(CareerArea::class, 'career_area_id');
}

// Uso
$curriculum = Curriculum::findById(1);
$area = $curriculum->careerArea();
echo $area->name;
```

### 5. Validação

```php
// No Model User.php
protected array $rules = [
    'name' => 'required|min:3',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:6',
    'role' => 'required|in:admin,manager,operator,viewer',
];

// Uso
$user = new User([
    'name' => 'Jo', // Falha: min:3
    'email' => 'invalid', // Falha: email
]);

if (!$user->save()) {
    $errors = $user->errors();
    // ['name' => ['O campo name deve ter no mínimo 3 caracteres']]
}
```

#### Regras de Validação Disponíveis

- `required` - Campo obrigatório
- `email` - Email válido
- `min:n` - Tamanho mínimo
- `max:n` - Tamanho máximo
- `unique:table,column` - Valor único no banco
- `confirmed` - Campo de confirmação (ex: password_confirmation)
- `in:val1,val2` - Valor deve estar na lista
- `numeric` - Valor numérico
- `integer` - Número inteiro
- `url` - URL válida
- `date` - Data válida

### 6. Soft Deletes

```php
use App\Traits\SoftDeletes;

class User extends BaseModel
{
    use SoftDeletes;
}

// Soft delete (marca deleted_at)
$user->delete();

// Restaurar
$user->restore();

// Verificar se está deletado
if ($user->trashed()) {
    echo "Usuário está deletado";
}

// Incluir deletados na query
$allUsers = User::withTrashed()->get();

// Apenas deletados
$deletedUsers = User::onlyTrashed()->get();

// Deletar permanentemente
$user->forceDelete();
```

### 7. Timestamps

```php
use App\Traits\HasTimestamps;

class User extends BaseModel
{
    use HasTimestamps;
}

// Timestamps são adicionados automaticamente
$user = User::create(['name' => 'João']);
echo $user->created_at; // 2024-01-15 10:30:00
echo $user->updated_at; // 2024-01-15 10:30:00

// Atualizar timestamp manualmente
$user->touch();
```

### 8. Events/Hooks

```php
class User extends BaseModel
{
    // Antes de salvar (insert ou update)
    protected function beforeSave(): void
    {
        // Hash password
        if (isset($this->attributes['password'])) {
            $this->attributes['password'] = password_hash(
                $this->attributes['password'], 
                PASSWORD_DEFAULT
            );
        }
    }
    
    // Depois de salvar
    protected function afterSave(): void
    {
        // Enviar email, log, etc.
    }
    
    // Antes de criar (apenas insert)
    protected function beforeCreate(): void
    {
        // Código aqui
    }
    
    // Depois de criar
    protected function afterCreate(): void
    {
        // Código aqui
    }
    
    // Antes de deletar
    protected function beforeDelete(): void
    {
        // Código aqui
    }
    
    // Depois de deletar
    protected function afterDelete(): void
    {
        // Código aqui
    }
}
```

### 9. Type Casting

```php
class User extends BaseModel
{
    protected array $casts = [
        'id' => 'integer',
        'last_login' => 'datetime',
        'settings' => 'json',
        'is_active' => 'boolean',
    ];
}

// Uso
$user = User::findById(1);
$lastLogin = $user->last_login; // DateTime object
$settings = $user->settings; // Array (convertido de JSON)
```

### 10. Mass Assignment Protection

```php
class User extends BaseModel
{
    // Campos permitidos
    protected array $fillable = [
        'name', 'email', 'password', 'role'
    ];
    
    // Campos protegidos
    protected array $guarded = ['id', 'created_at'];
}

// Apenas campos fillable serão preenchidos
$user = User::create($_POST); // Seguro!
```

## 📝 Exemplos Práticos

### Exemplo 1: Sistema de Login

```php
use App\Models\User;

$email = $_POST['email'];
$password = $_POST['password'];

$user = User::where('email', $email)->first();

if ($user && $user->verifyPassword($password)) {
    if ($user->isActive()) {
        $user->updateLastLogin();
        $_SESSION['user_id'] = $user->id;
        // Login bem-sucedido
    }
}
```

### Exemplo 2: Listagem com Paginação

```php
use App\Models\User;

$page = $_GET['page'] ?? 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

$users = User::active()
             ->orderBy('name', 'ASC')
             ->limit($perPage)
             ->offset($offset)
             ->get();

$total = User::active()->count();
$totalPages = ceil($total / $perPage);
```

### Exemplo 3: Busca com Filtros

```php
use App\Models\User;

$query = User::make();

if (!empty($_GET['role'])) {
    $query->where('role', $_GET['role']);
}

if (!empty($_GET['department'])) {
    $query->where('department', $_GET['department']);
}

if (!empty($_GET['status'])) {
    $query->where('status', $_GET['status']);
}

$users = $query->orderBy('name', 'ASC')->get();
```

### Exemplo 4: Relacionamentos

```php
use App\Models\Curriculum;

// Buscar currículo com área
$curriculum = Curriculum::findById(1);
$area = $curriculum->careerArea();

echo "Candidato: {$curriculum->name}";
echo "Área: {$area->name}";

// Buscar área com currículos
$area = CareerArea::findById(1);
$curriculums = $area->curriculums();

echo "Área: {$area->name}";
echo "Total de currículos: " . count($curriculums);
```

## 🔧 Executar Migration de Soft Deletes

Para adicionar a coluna `deleted_at` nas tabelas:

```bash
# No Docker
docker exec -it <container-name> bash
php bin/migrations migrations:migrate

# Ou localmente
php bin/migrations migrations:migrate
```

## 🧪 Testar os Models

Execute o arquivo de teste:

```bash
php test-models.php
```

## 📚 Models Disponíveis

### User
- Gerenciamento de usuários
- Autenticação e autorização
- Soft deletes habilitado
- Scopes: `active()`, `byRole()`, `byDepartment()`

### Slider
- Gerenciamento de slides do carrossel
- Soft deletes habilitado
- Scopes: `active()`, `ordered()`

### Curriculum
- Gerenciamento de currículos
- Relacionamento com CareerArea
- Soft deletes habilitado
- Scopes: `new()`, `inAnalysis()`, `approved()`, `recent()`

### CareerArea
- Áreas de carreira
- Relacionamento com Curriculum
- Scopes: `active()`

## 💡 Dicas e Boas Práticas

1. **Sempre use os Models** ao invés de queries diretas
2. **Defina regras de validação** nos Models
3. **Use Query Scopes** para queries reutilizáveis
4. **Aproveite os Events** para lógica automática
5. **Proteja mass assignment** com $fillable/$guarded
6. **Use Soft Deletes** ao invés de deletar permanentemente
7. **Defina relacionamentos** para facilitar queries
8. **Use Type Casting** para conversão automática

## 🎯 Benefícios

✅ **Código mais limpo** - Controllers focam em lógica de negócio  
✅ **Reutilização** - Lógica de dados centralizada  
✅ **Validação automática** - Dados sempre validados  
✅ **Segurança** - Mass assignment protection  
✅ **Manutenibilidade** - Mudanças no banco refletem apenas nos Models  
✅ **Testabilidade** - Models podem ser testados isoladamente  
✅ **Produtividade** - Menos código repetitivo  

## 📄 Licença

Este sistema foi desenvolvido para o projeto Dellaconsul SaaS 1.0.
