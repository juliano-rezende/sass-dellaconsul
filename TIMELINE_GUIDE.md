# 📅 Guia da Timeline - Nossa Jornada

## Visão Geral

Implementação de uma **timeline vertical moderna** mostrando a jornada da Dellaconsul em 3 etapas:
1. **História** - O início de tudo
2. **Objetivos** - Nossos propósitos
3. **Futuro** - Rumo ao amanhã

---

## 🎨 Características do Design

### Layout Desktop (> 991px)
- ✅ Linha vertical central colorida (degradê)
- ✅ Cards alternados (esquerda/direita)
- ✅ **Imagem e texto lado a lado** (horizontal) em cada card
- ✅ Imagem: 35% da largura / Texto: 65% da largura
- ✅ Ícones circulares no centro da linha
- ✅ Largura: 45% para cada card
- ✅ Layout compacto e eficiente

### Layout Mobile (< 991px)
- ✅ Linha vertical à esquerda
- ✅ Cards alinhados à direita da linha
- ✅ Ícones menores
- ✅ Layout mais compacto

---

## 🎯 Elementos da Timeline

### 1. Linha Vertical
- **Cor:** Degradê (Azul → Verde → Ciano)
- **Largura:** 3px
- **Posição:** Centro (desktop) / Esquerda (mobile)

### 2. Ícones
- **História:** 🚩 Bandeira (Azul)
- **Objetivos:** 🎯 Alvo (Verde)
- **Futuro:** 🚀 Foguete (Ciano)
- **Tamanho:** 60px (desktop) / 40px (mobile)
- **Efeito:** Rotação 360° ao passar o mouse

### 3. Cards
- **Background:** Branco
- **Sombra:** Elevada
- **Bordas:** Arredondadas (20px)
- **Layout:** Flexbox horizontal (imagem + texto lado a lado)
- **Imagem:** 35% largura, 300px altura mínima
- **Texto:** 65% largura, padding 2rem
- **Efeito Hover:** Elevação + Zoom na imagem

### 4. Badges
- **História:** Badge azul
- **Objetivos:** Badge verde
- **Futuro:** Badge ciano
- **Formato:** Arredondado com ícone

---

## 📱 Responsividade

| Breakpoint | Comportamento |
|------------|---------------|
| **Desktop** (>991px) | Timeline centralizada, cards alternados, imagem e texto horizontal |
| **Tablet** (768-991px) | Timeline à esquerda, cards à direita, imagem acima do texto |
| **Mobile** (<576px) | Timeline compacta à esquerda, imagem acima do texto |

---

## 🎭 Animações

1. **Hover no Card:**
   - Elevação: `translateY(-10px)`
   - Sombra aumentada
   - Zoom na imagem (1.1x)

2. **Hover no Ícone:**
   - Rotação 360°
   - Escala aumentada (1.15x)

3. **Transições:**
   - Suaves (0.3s)
   - Easing natural

---

## 🖼️ Imagens Temporárias

Atualmente usando Unsplash:

| Seção | URL |
|-------|-----|
| **História** | [Profissional](https://images.unsplash.com/photo-1560179707-f14e90ef3623) |
| **Objetivos** | [Checklist](https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b) |
| **Futuro** | [Tecnologia](https://images.unsplash.com/photo-1451187580459-43490279c0fa) |

### Como Substituir:

1. Salve suas imagens em: `themes/site/default/assets/images/`
2. Nomes sugeridos: `historia.jpg`, `objetivos.jpg`, `futuro.jpg`
3. Edite `home.php` (linhas ~175-245)
4. Substitua as URLs do Unsplash por:

```php
<img src="<?=urlBase(THEME_SITE .'/assets/images/historia.jpg');?>" alt="História">
```

---

## 📝 Conteúdo das Seções

### História
- **Título:** "O Início de Tudo"
- **Badge:** Azul com ícone de história
- **Conteúdo:** Texto sobre metas ousadas e criação da empresa
- **Lista:** 2 exemplos (casas populares, programa de computador)

### Objetivos
- **Título:** "Nossos Propósitos"
- **Badge:** Verde com ícone de alvo
- **Conteúdo:** Texto poético sobre capacidades e determinação
- **Formato:** Versos em itálico

### Futuro
- **Título:** "Rumo ao Amanhã"
- **Badge:** Ciano com ícone de foguete
- **Conteúdo:** Compromisso com o futuro e valores
- **Destaque:** Nome "Darci Rodrigues" em negrito

---

## 🎨 Paleta de Cores

| Elemento | Cor | Hex |
|----------|-----|-----|
| História | Azul Primário | `var(--primary-color)` |
| Objetivos | Verde Sucesso | `var(--success-color)` |
| Futuro | Ciano Info | `#17a2b8` |
| Texto | Cinza 600 | `var(--gray-600)` |
| Background | Branco | `white` |

---

## 🔧 Personalização

### Alterar Cores dos Badges:
No CSS (`style.css`), procure por `.timeline-badge` e ajuste:
```css
.timeline-badge.bg-primary { background: #SEU_AZUL !important; }
.timeline-badge.bg-success { background: #SEU_VERDE !important; }
.timeline-badge.bg-info { background: #SEU_CIANO !important; }
```

### Alterar Ícones:
No PHP (`home.php`), substitua as classes Font Awesome:
```php
<i class="fas fa-SEU-ICONE"></i>
```

### Adicionar Mais Etapas:
Copie um bloco `<div class="timeline-item">...</div>` e ajuste o conteúdo.

---

## ✅ Resultado Final

- ✅ Timeline vertical moderna e elegante
- ✅ Sem datas (foco na jornada)
- ✅ 3 etapas claramente definidas
- ✅ Design responsivo para todos os dispositivos
- ✅ Animações suaves e profissionais
- ✅ Fácil de personalizar e expandir

---

## 📍 Localização no Site

- **URL:** `/#sobre` (seção Sobre)
- **Posição:** Após o conteúdo principal da seção "A Dellaconsul"
- **Arquivo:** `themes/site/default/pages/home.php`
- **Estilos:** `themes/site/default/assets/css/style.css`

---

**Pronto para uso!** 🎉
