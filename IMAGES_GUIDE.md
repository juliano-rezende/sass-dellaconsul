# Guia de Imagens - Timeline "Nossa Jornada"

## Imagens Necessárias

Para personalizar completamente a timeline da seção "Sobre a Empresa", você precisa adicionar as seguintes imagens:

### 1. História (historia.jpg)
**Caminho:** `themes/site/default/assets/images/historia.jpg`
- **Descrição:** Foto do Darci Rodrigues (fundador/CEO) ou imagem representando o início da empresa
- **Dimensões recomendadas:** 800x500px (proporção 16:10)
- **Formato:** JPG ou PNG
- **Origem:** Imagem 1 que você forneceu (foto do Darci Rodrigues)

### 2. Objetivos (objetivos.jpg)
**Caminho:** `themes/site/default/assets/images/objetivos.jpg`
- **Descrição:** Imagem representando objetivos/metas/propósitos
- **Dimensões recomendadas:** 800x500px (proporção 16:10)
- **Formato:** JPG ou PNG
- **Sugestão:** Imagem com post-its, quadro de objetivos, checklist, ou reunião de planejamento

### 3. Futuro (futuro.jpg)
**Caminho:** `themes/site/default/assets/images/futuro.jpg`
- **Descrição:** Imagem representando o futuro e visão da empresa
- **Dimensões recomendadas:** 800x500px (proporção 16:10)
- **Formato:** JPG ou PNG
- **Sugestão:** Imagem futurista, cidade moderna, tecnologia, estrada para o horizonte

## Como Substituir as Imagens

### Passo 1: Salvar as Imagens
1. Salve suas imagens na pasta: `themes/site/default/assets/images/`
2. Renomeie-as conforme indicado acima (historia.jpg, objetivos.jpg, futuro.jpg)

### Passo 2: Atualizar o Código

Edite o arquivo: `themes/site/default/pages/home.php`

Procure pelas 3 ocorrências de `<div class="timeline-image">` (aproximadamente linhas 175-245) e substitua os URLs:

**História:**
```php
<div class="timeline-image">
    <img src="https://images.unsplash.com/photo-1560179707-f14e90ef3623..." 
         alt="História">
</div>
```

Substitua por:

```php
<div class="timeline-image">
    <img src="<?=urlBase(THEME_SITE .'/assets/images/historia.jpg');?>" 
         alt="História">
</div>
```

**Objetivos:**
```php
<div class="timeline-image">
    <img src="https://images.unsplash.com/photo-1484480974693..." 
         alt="Objetivos">
</div>
```

Substitua por:

```php
<div class="timeline-image">
    <img src="<?=urlBase(THEME_SITE .'/assets/images/objetivos.jpg');?>" 
         alt="Objetivos">
</div>
```

**Futuro:**
```php
<div class="timeline-image">
    <img src="https://images.unsplash.com/photo-1451187580459..." 
         alt="Futuro">
</div>
```

Substitua por:

```php
<div class="timeline-image">
    <img src="<?=urlBase(THEME_SITE .'/assets/images/futuro.jpg');?>" 
         alt="Futuro">
</div>
```

## Imagens Temporárias

Atualmente, o site está usando imagens temporárias do Unsplash:
- **História:** Imagem de pessoa profissional
- **Objetivos:** Imagem de checklist/objetivos
- **Futuro:** Imagem futurista/tecnologia

Essas imagens funcionam perfeitamente até você adicionar as imagens definitivas.

## Resultado

Após adicionar as imagens, a seção "Sobre" terá:
- ✅ Texto principal com informações da empresa
- ✅ 4 características em destaque
- ✅ Imagem principal da equipe
- ✅ **Timeline vertical moderna** com 3 etapas (História, Objetivos, Futuro)
- ✅ Linha colorida conectando as etapas
- ✅ Ícones circulares animados
- ✅ Cards alternados (desktop) ou alinhados (mobile)
- ✅ Design responsivo e moderno
- ✅ Animações suaves ao passar o mouse

## Visualizar o Site

Para visualizar as mudanças, acesse:
- URL local do projeto (geralmente http://localhost ou a porta configurada no Docker)
- Navegue até a seção "Sobre" (#sobre)
