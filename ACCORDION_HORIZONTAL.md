# 🎭 Accordion Horizontal - Nossa Jornada

## ✨ Visão Geral

Accordion horizontal moderno e interativo com 3 painéis:
- **1 painel aberto** mostrando todo o conteúdo
- **2 painéis fechados** mostrando apenas ícone e título vertical
- **Clique para expandir** qualquer painel

---

## 🎯 Funcionamento

### Estado Inicial
- **História**: ABERTO (painel 1)
- **Objetivos**: FECHADO (painel 2)
- **Futuro**: FECHADO (painel 3)

### Interação
1. Clique em um painel fechado
2. Ele se expande suavemente
3. O painel atual se comprime
4. Animação fluida de transição (0.6s)

---

## 📐 Layout

### Desktop (> 991px):

```
┌──────┐ ┌────────────────────────────────────────────────┐ ┌──────┐
│      │ │ ╔══════╗  ┌────────────────────────────────┐  │ │      │
│  🎯  │ │ ║      ║  │ Badge + Título                 │  │ │  🚀  │
│      │ │ ║IMAGEM║  │ Texto completo do conteúdo...  │  │ │      │
│Objet.│ │ ║      ║  │ Texto completo do conteúdo...  │  │ │Futuro│
│      │ │ ║ 40% ║  │ Lista de itens...              │  │ │      │
│      │ │ ╚══════╝  │           60%                  │  │ │      │
│      │ │           └────────────────────────────────┘  │ │      │
└──────┘ └────────────────────────────────────────────────┘ └──────┘
Fechado               ABERTO (História)                    Fechado
100px                    Flex: 1                           100px
```

### Mobile (< 991px):

```
┌─────────────────────────────────┐
│ 🎯 Objetivos                    │  ← Fechado (80px altura)
└─────────────────────────────────┘

┌─────────────────────────────────┐
│ ╔═════════════════════════════╗ │
│ ║      IMAGEM HISTÓRIA        ║ │
│ ╚═════════════════════════════╝ │
│                                 │
│ 🔵 História                    │
│ O Início de Tudo               │
│                                 │
│ Texto completo...               │  ← ABERTO (600px altura)
│ • Item 1                        │
│ • Item 2                        │
└─────────────────────────────────┘

┌─────────────────────────────────┐
│ 🚀 Futuro                       │  ← Fechado (80px altura)
└─────────────────────────────────┘
```

---

## 🎨 Características Visuais

### Painéis Fechados
- **Largura:** 100px
- **Ícone:** 70px circular com gradiente
- **Título:** Texto vertical (writing-mode)
- **Background:** Gradiente sutil
- **Cursor:** Pointer (clicável)

### Painel Aberto
- **Largura:** Flex 1 (preenche espaço disponível)
- **Layout:** Imagem 40% + Texto 60%
- **Borda:** 2px colorida (cor do tema)
- **Animação:** FadeIn suave
- **Scroll:** Automático se conteúdo exceder altura

---

## 🎨 Cores e Ícones

| Painel | Ícone | Cor Principal | Gradiente |
|--------|-------|---------------|-----------|
| **História** | 🚩 fa-history | Azul Primário | #2563eb → #1d4ed8 |
| **Objetivos** | 🎯 fa-bullseye | Verde Sucesso | #10b981 → #059669 |
| **Futuro** | 🚀 fa-rocket | Ciano Info | #17a2b8 → #0891b2 |

---

## ⚡ Animações

### 1. Expansão do Painel
```
Duração: 0.6s
Easing: cubic-bezier(0.4, 0, 0.2, 1)
Propriedades: flex, opacity
```

### 2. FadeIn do Conteúdo
```
Duração: 0.6s
Delay: 0.2s
Efeito: Opacity 0→1 + TranslateY 10px→0
```

### 3. Hover no Ícone (fechado)
```
Transform: scale(1.1) rotate(5deg)
Duração: 0.4s
```

### 4. Hover na Imagem (aberto)
```
Transform: scale(1.05)
Duração: 0.6s
```

---

## 💻 JavaScript

### Função Principal
```javascript
function togglePanel(panelName) {
    const panels = document.querySelectorAll('.accordion-panel');
    const clickedPanel = document.querySelector(`[data-panel="${panelName}"]`);
    
    panels.forEach(panel => {
        if (panel.dataset.panel === panelName) {
            panel.classList.add('active');
        } else {
            panel.classList.remove('active');
        }
    });
}
```

### Como Funciona
1. Seleciona todos os painéis
2. Remove classe `active` de todos
3. Adiciona classe `active` ao painel clicado
4. CSS cuida das animações

---

## 📱 Responsividade

### Desktop (> 991px)
- Accordion horizontal
- Painéis lado a lado
- Fechado: 100px largura
- Aberto: Flex 1 (dinâmico)
- Altura: 500px

### Tablet (768-991px)
- Accordion vertical
- Painéis empilhados
- Fechado: 80px altura
- Aberto: 600px altura
- Layout da imagem: acima do texto

### Mobile (< 576px)
- Accordion vertical
- Painéis empilhados
- Fechado: 70px altura
- Aberto: 550px altura
- Ícones menores (40px)
- Padding reduzido

---

## 🔧 Personalização

### Alterar Altura do Accordion
```css
.accordion-horizontal {
    height: 500px; /* Altere aqui */
}
```

### Alterar Largura dos Painéis Fechados
```css
.accordion-panel {
    flex: 0 0 100px; /* Altere o 100px */
}
```

### Alterar Velocidade da Animação
```css
.accordion-panel {
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    /* Altere 0.6s para a velocidade desejada */
}
```

### Alterar Proporção Imagem/Texto
```css
.panel-image {
    width: 40%; /* Altere aqui */
}
/* O texto ocupará o espaço restante automaticamente */
```

---

## ✅ Vantagens

✅ **Interativo** - Clique para explorar cada seção
✅ **Compacto** - Economiza espaço vertical
✅ **Moderno** - Visual contemporâneo e elegante
✅ **Fluido** - Animações suaves e naturais
✅ **Responsivo** - Adapta perfeitamente a todos os dispositivos
✅ **Intuitivo** - Fácil de usar e entender
✅ **Performático** - Apenas CSS e JavaScript vanilla
✅ **Acessível** - Funciona em todos os navegadores

---

## 🎯 Comportamento

### Desktop
- **Hover em painel fechado:** Ícone aumenta e rotaciona
- **Clique em painel fechado:** Expande e comprime outros
- **Hover em painel aberto:** Imagem dá zoom suave

### Mobile
- **Toque em painel fechado:** Expande suavemente
- **Painéis verticais:** Melhor para telas pequenas
- **Scroll automático:** Se conteúdo exceder altura

---

## 📊 Dimensões

### Desktop
| Elemento | Fechado | Aberto |
|----------|---------|--------|
| Painel | 100px | Flex 1 |
| Ícone | 70px | N/A |
| Imagem | N/A | 40% |
| Texto | N/A | 60% |
| Altura | 500px | 500px |

### Mobile
| Elemento | Fechado | Aberto |
|----------|---------|--------|
| Painel | 70px | 550px |
| Ícone | 40px | N/A |
| Imagem | N/A | 200px |
| Texto | N/A | 100% |

---

## 🚀 Performance

- **CSS Puro** para animações (GPU acelerado)
- **JavaScript Mínimo** (< 10 linhas)
- **Sem bibliotecas** externas necessárias
- **Smooth 60 FPS** em todos os dispositivos

---

## ✨ Destaques

1. **Scroll Customizado** no painel aberto
2. **Borda Colorida** indica painel ativo
3. **Texto Vertical** nos painéis fechados
4. **Gradientes** nos ícones e badges
5. **Transições Suaves** com cubic-bezier
6. **Mobile-First** design responsivo

---

**Pronto para uso! Interface moderna e interativa que impressiona.** 🎉
