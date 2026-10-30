# Plan: View Profile Modal for Pet Cards (Owner Dashboard)

**File:** `resources/views/Client/owner_dashboard.blade.php`
**Scope:** Add a tabbed "View Profile" modal triggered by the existing "View Profile" button on each pet card. Modal shows consolidated pet data organized by category tabs.

## Decisions (resolved)

1. **Data loading strategy**: Inline JSON `const petsData = @json($pets);` — follows existing `view_pets.blade.php` pattern, instant modal open, no new route.
2. **Tab labels**: Overview | Health & Vaccination | Spay / Neuter | Details & Traits.
3. **Edit action**: Include "Edit Pet" button linking to `/owner/pets/{pet_id}/edit` (matches `view_pets.blade.php` pattern).
4. **Medical records**: Shown in Health tab; eager-load `medicalRecords`.
5. **Eager loading**: Change pets query to `Pet::with(['petInfo', 'medicalRecords', 'vaccinationReports'])->where('owner_id', ...)->get()` to avoid N+1 on JSON serialization.
6. **VaccinationReports relationship**: Add `public function vaccinationReports(): HasMany` to `app/Models/Pet.php` so JS reads `pet.vaccinationReports` directly instead of the separate `$vaccinationReports` keyed collection.
7. **Vaccination lookup in modal**: Replace separate keyed-collection lookup with `pet.vaccinationReports` array from serialized JSON.

## Data Sources Available (per pet)

| Source | Model | Key Fields |
|--------|-------|------------|
| Pet | `App\Models\Pet` | pet_id, pet_name, species, breed, gender, birthdate, pet_image, color, microchip_number, vaccination_status, vaccination_date, next_vaccination_date, health_status, medical_history, notes, body_mark_details, body_mark_image, additional_photos, pet_status, owner, petInfo |
| PetInfo | `App\Models\PetInfo` | is_neutered, is_crossbreed, pet_age, pet_weight, eye_color, training (array), insurance (array), behavior (array), likes (array), dislikes (array), diet (array), allergy (array) |
| VaccinationReport | `App\Models\VaccinationReport` | vaccine_brand, vaccine_batch_number, vaccination_date, vaccination_time, next_vaccination_date, weight, vaccination_type, status, observations, notes |
| SpayNeuterAppointment | `App\Models\SpayNeuterAppointment` | procedure_type, scheduled_at, status, veterinarian, weight |
| MedicalRecord | `App\Models\MedicalRecord` | diagnosis, treatment, veterinarian_id, created_at |

## Tab Structure (4 tabs)

### Tab 1: Overview (identity)
- Pet photo (large), name, species, breed, gender, age, weight
- PET ID, color, microchip number, pet status
- Owner name, barangay
- Registration date (created_at)

### Tab 2: Health & Vaccination
- Vaccination status badge (active / needed / no record)
- Vaccine brand, batch number, vaccination date, next due date
- Medical records list (diagnosis, treatment, date, veterinarian)

### Tab 3: Spay / Neuter
- Status (Yes / No), source (registration vs completed appointment)
- Procedure type (spay / neuter), appointment date, veterinarian

### Tab 4: Details & Traits
- Eye color, crossbreed (Yes/No)
- Body mark details
- Training, insurance, behavior, likes, dislikes, diet, allergies (array chips, hidden if empty)

## Implementation Steps

1. Modify pets query in `owner_dashboard.blade.php`: add `with(['petInfo', 'medicalRecords', 'vaccinationReports'])`.
2. Add `vaccinationReports()` relationship to `app/Models/Pet.php`.
3. Serialize pets to JSON: `const petsData = @json($pets);` in a `<script>` block.
4. Change "View Profile" button `onclick="showPetProfile({{ $pet->pet_id }})"`.
5. Add modal HTML before `</body>` following existing modal pattern (`fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4`, `bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto`).
6. Build tabbed UI: tab buttons + tab panels, one visible at a time.
7. JS functions: `showPetProfile(petId)`, `closePetProfile()`, ESC/click-outside close, tab switching.
8. Use `data-lucide` icons in modal headers per tab (lucide already loaded).

## Validation
- Open dashboard as authenticated pet owner with at least one pet.
- Click "View Profile" on a card → modal opens with correct pet data.
- Tab switching works; correct panel shows per tab.
- Empty array fields (likes/dislikes/etc.) hide their sections gracefully.
- Click outside / ESC closes modal.
- No console errors (lucide icons render).

## Out of Scope
- Persisting edits from the modal (Edit button links to existing edit page).
- Vaccine passport download (previously removed per user request).
