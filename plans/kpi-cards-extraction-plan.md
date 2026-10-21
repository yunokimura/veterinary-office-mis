# KPI Cards Extraction Plan

## Overview
Extract the KPI (Key Performance Indicator) cards from the City Vet Dashboard HTML. These are the four summary cards in the "Top Row: Key Metrics Summary Cards" section.

## Affected Area
- `resources/views/city-vet/` - Dashboard view integration
- HTML structure for KPI card components

## KPI Cards to Extract

### Card 1: Rabies Cases
- **Class**: `bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden group`
- **Header**: "Confirmed Rabies Cases" (text-xs font-bold text-slate-500 uppercase tracking-wider)
- **Value**: `30` (text-3xl font-extrabold text-slate-900 tracking-tight)
- **Subtitle**: "Total Cases" (text-xs font-medium text-slate-500)
- **Badges Grid** (grid grid-cols-2 gap-1.5):
  - Dog: 12 (amber-50 bg-amber-700)
  - Cat: 18 (indigo-50 bg-indigo-700)
  - Stray: 10 (rose-50 bg-rose-700)
  - Owned: 20 (emerald-50 bg-emerald-700)
- **Background accent**: Absolute `w-24 h-24 bg-rose-500/5 rounded-full -mr-8 -mt-8`

### Card 2: Anti-Rabies Vaccination Performance
- **Class**: Same as Card 1
- **Header**: "Anti-Rabies Vaccination" (text-xs font-bold text-slate-500 uppercase tracking-wider)
- **Value**: `0.2%` (text-3xl font-extrabold text-slate-900 tracking-tight)
- **Subtitle**: "Performance" (text-xs font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded)
- **Progress Bar**: `w-full bg-slate-100 rounded-full h-2 overflow-hidden` with `bg-brand-600 h-2 rounded-full` width 0.2%
- **Background accent**: Absolute `w-24 h-24 bg-brand-500/5 rounded-full -mr-8 -mt-8`
- **Icon**: syringe (data-lucide="syringe")

### Card 3: Pet Adoption Performance
- **Class**: Same as Card 1
- **Header**: "Pet Adoption Rate" (text-xs font-bold text-slate-500 uppercase tracking-wider)
- **Value**: `0%` (text-3xl font-extrabold text-slate-900 tracking-tight)
- **Subtitle**: "Adoption Rate" (text-xs font-medium text-slate-500)
- **Status Tags** (flex items-center space-x-2):
  - Pending: 4 (amber-50 bg-amber-700 text-xs font-semibold)
  - Approved: 0 (emerald-50 bg-emerald-700 text-xs font-semibold)
- **Background accent**: Absolute `w-24 h-24 bg-blue-500/5 rounded-full -mr-8 -mt-8`
- **Icon**: heart (data-lucide="heart")

### Card 4: Missing Pet Recovery
- **Class**: Same as Card 1
- **Header**: "Missing Pet Recovery" (text-xs font-bold text-slate-500 uppercase tracking-wider)
- **Value**: `0%` (text-3xl font-extrabold text-slate-900 tracking-tight)
- **Subtitle**: "Recovery Rate" (text-xs font-medium text-slate-500)
- **Status Tags** (flex items-center space-x-2):
  - Resolved: 0 (emerald-50 bg-emerald-700 text-xs font-semibold)
  - Active: 10 (blue-50 bg-blue-700 text-xs font-semibold)
- **Background accent**: Absolute `w-24 h-24 bg-amber-500/5 rounded-full -mr-8 -mt-8`
- **Icon**: radar (data-lucide="radar")

## Extraction Output Structure
Each card should be extracted as a standalone HTML div with its complete inner content, preserving:
- Tailwind CSS classes
- Lucide icon references
- Inline styles
- Relative positioning and absolute background elements
- Grid/badge layouts

## Integration Notes
- Cards use `grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5` layout
- Each card has `group` class for hover effects
- Background accent absolute positions use negative margins (`-mr-8 -mt-8`)
- Progress bars and status tags have specific Tailwind configurations

## Risks & Considerations
- Ensure Tailwind config matches the brand colors defined in the `<script>` tag
- Lucide icons must remain accessible via CDN
- Hover shadow effects depend on `transition-shadow` and `group` classes
- The `p-5` padding and `rounded-2xl` radius are consistent across all cards

## Validation
- Verify all 4 cards render correctly with proper values
- Check hover shadow transitions work
- Confirm badge counts and colors are consistent
- Ensure progress bar percentage renders correctly