# Sidebar UI/UX Accessibility & Visual Hierarchy Plan

**Target file:** `resources/views/layouts/admin.blade.php` (sidebar CSS at lines 38–88, nav HTML at lines 198–350)

**Goal:** Fix WCAG AA contrast failures, rebalance visual hierarchy so navigation links outrank section headers, crisp active-state treatment, and consistent spacing/alignment across all sidebar menu items.

---

## Current State

| Element | Selector | Current Value | Problem |
|---|---|---|---|
| Nav item text color | `.nav-item` | `rgba(167, 243, 208, 0.7)` (~70% mint) | Fails WCAG AA contrast on dark-green bg |
| Nav item font | `.nav-item` | 13.5px, weight 500 | Less prominent than section headers |
| Nav item padding | `.nav-item` | 9px 14px | Inconsistent with section labels (12px 16px) |
| Section header color | `.sidebar-section-label` | `#ffffff` (100% white) | Overpowers nav links |
| Section header font | `.sidebar-section-label` | 10.5px, weight 700, uppercase | Heavier than nav items |
| Active state | `.nav-item.active-nav` | bg `#047857`, color `#ffffff` | No accent bar; distinction is subtle |
| Icon color | `.nav-item i` | inherits (muted) | Low contrast when parent is muted |

**Affected roles:** All sidebar roles (super_admin, city_vet, assistant_vet, admin_asst, meat_inspector, fallback) since they all share `.nav-item` and `.sidebar-section-label` classes.

---

## Design Decisions

### 1. Color Contrast & Accessibility (WCAG AA)
- `.nav-item` color: `rgba(167, 243, 208, 0.7)` → `#ffffff` (pure white)
  - Rationale: Pure white on `bg-[#064e3b]` exceeds 4.5:1 contrast ratio; simplest, most readable option per user spec.
- `.nav-item:hover` color: `#a7f3d0` → `#ffffff` (brighter white on hover for feedback)
- Bootstrap Icons (`<i>`) inherit `color` from `.nav-item` via `currentColor` — no separate change needed.

### 2. Visual Hierarchy & Typography
- `.sidebar-section-label`:
  - font-size: `10.5px` → `11px`
  - font-weight: `700` → `600`
  - color: `#ffffff` → `rgba(255, 255, 255, 0.65)` (~65% opacity white)
  - Keep: uppercase, letter-spacing `0.08em`, padding `12px 16px 6px`
  - Rationale: Section headers become subtle visual separators; nav links become primary focus.
- `.nav-item`:
  - font-size: `13.5px` → `14px`
  - font-weight: `500` → `600`
  - Rationale: Bolder, slightly larger link text draws primary focus over section headers.

### 3. Active State Treatment
- `.nav-item.active-nav`:
  - background: keep `#047857`
  - color: keep `#ffffff`
  - Add: `border-left: 3px solid #a7f3d0` (vertical accent bar)
  - Rationale: Crisp vertical accent bar provides unambiguous active indication without relying solely on background shade. White label on darker fill remains high-contrast.

### 4. Alignment & Spacing
- `.nav-item` padding: `9px 14px` → `12px 16px` (consistent vertical rhythm with section labels)
- `.nav-item i`: keep `width: 20px`, `font-size: 16px`, `flex-shrink: 0`, `text-align: center` (icons already vertically centered via flex)
- Reports submenu items (lines 279–296): remove inline `px-2 py-1` padding override so they inherit `12px 16px` from `.nav-item`; keep `ml-4` indent for visual hierarchy
- `.sidebar-divider`: keep `margin: 12px 16px` (already consistent)

---

## Implementation Tasks

1. **Update `.nav-item` CSS** (line 59–71): Change `color` to `#ffffff`, `font-size` to `14px`, `font-weight` to `600`, `padding` to `12px 16px`
2. **Update `.nav-item:hover`** (line 72): Change `color` to `#ffffff`
3. **Update `.nav-item.active-nav`** (line 73–77): Add `border-left: 3px solid #a7f3d0`
4. **Update `.sidebar-section-label` CSS** (line 81–88): Change `font-weight` to `600`, `color` to `rgba(255, 255, 255, 0.65)`
5. **Update Reports submenu items** (lines 279–296): Remove `px-2 py-1` from each submenu `<a>` class so they inherit `.nav-item` padding; keep `block rounded-md transition-colors`
6. **Verify icon alignment**: Confirm `<i>` elements remain vertically centered with text via existing `align-items: center` on `.nav-item`

---

## Validation

- Visually inspect sidebar in browser for all roles: super_admin, city_vet, assistant_vet, admin_asst, meat_inspector, fallback
- Confirm active state shows vertical accent bar on the current route
- Confirm section headers appear lighter/subtler than nav links
- Confirm text contrast passes WCAG AA (white on `#064e3b` background)
- Confirm consistent padding across all nav item rows including submenu items
- Mobile sidebar (toggle) still functions; no layout regression at `< 767px`

---

## Out of Scope

- `resources/views/partials/sidebar.blade.php` — already deleted; not referenced by any view
- Other layouts or Blade files that don't extend `layouts.admin`
- Non-sidebar UI components (headers, modals, tables, forms)
