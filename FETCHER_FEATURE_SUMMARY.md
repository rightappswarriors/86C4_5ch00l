# Fetcher Information Feature - Database & Code Summary

## 1. DATABASE SCHEMA

**File:** `Sql/fetcher_registration.sql`

```sql
CREATE TABLE IF NOT EXISTS `fetcher_registration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fetcher_data` text NOT NULL,          -- JSON array of fetcher objects
  `student_data` text NOT NULL,          -- JSON array of student objects
  `notes` text,                          -- Optional additional notes
  `registered_date` datetime NOT NULL,   -- Timestamp of registration
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
```

**Columns Explained:**

| Column | Type | Purpose | Example Value |
|--------|------|---------|---------------|
| `id` | int(11) AI PK | Auto-increment application number | 1, 2, 3... |
| `fetcher_data` | text (JSON) | JSON-encoded array of up to 2 fetchers | `[{"firstname":"Maria","middlename":"S","lastname":"Rustila","relationship":"Mother","contact_number":"09951234567"},...]` |
| `student_data` | text (JSON) | JSON-encoded array of students (any count) | `[{"fullname":"Juan Dela Cruz","grade":"Grade 3","section":"A"},...]` |
| `notes` | text | Optional special instructions from parent | "Please call before fetching" |
| `registered_date` | datetime | When application was submitted | `2025-04-18 15:30:00` |

**No foreign keys** — data is denormalized (JSON) for historical record-keeping.

---

## 2. MODEL QUERIES (Students_model.php)

**File:** `application/models/Students_model.php` (lines 450-467)

### Insert new registration
```php
function fetcher_register($data)
{
    $this->db->insert('fetcher_registration', $data);
    return $this->db->insert_id();
}
```

**Called from:** `Students::fetcher_id_submit()` with:
```php
$data = [
    'fetcher_data'    => json_encode($this->input->post('fetcher')),
    'student_data'    => json_encode($this->input->post('student')),
    'notes'           => $this->input->post('notes'),
    'registered_date' => date("Y-m-d H:i:s")
];
```

### Get single registration by ID
```php
function get_fetcher_registration($id)
{
    $this->db->where('id', $id);
    $query = $this->db->get('fetcher_registration');
    return $query->row();  // Returns object or null
}
```

**Used in:** `Students::fetcher_print($id)` → passes to print view

### List all registrations (newest first)
```php
function fetcher_registration_list()
{
    $this->db->order_by('registered_date', 'DESC');
    $query = $this->db->get('fetcher_registration');
    return $query->result();  // Returns array of objects
}
```

**Used in:** `Students::fetcher_info()` (admin view) and `Students::fetcher_list()` (parent view)

---

## 3. CONTROLLER ROUTES & METHODS

**File:** `application/controllers/Students.php`

### New endpoint for admin/staff
```php
public function fetcher_info()
{
    // Access: Admin, Accounting, Registrar, Principal only
    $allowed_roles = ['Admin', 'Accounting', 'Registrar', 'Principal'];
    $user_role = $this->session->userdata('current_usertype');
    
    if (!in_array($user_role, $allowed_roles)) {
        show_error('Unauthorized Access', 403);
        return;
    }
    
    $data = [
        'title'    => "Fetcher Information",
        'template' => 'students/fetcher_info',
        'query'    => $this->students_model->fetcher_registration_list()
    ];
    
    $this->load->view('template', $data);
}
```
**Route:** `GET /students/fetcher_info`

### Modified print endpoint (cleaner output)
```php
public function fetcher_print($id)
{
    $record = $this->students_model->get_fetcher_registration($id);
    if (!$record) show_404();
    
    $this->load->view('students/fetch_registration_print', [
        'title' => "Fetcher's ID Application",
        'record' => $record
    ]);
}
```
**Route:** `GET /students/fetcher_print/{id}`

**Note:** Changed from `$this->load->view('template', $data)` to direct view load to avoid double HTML wrapper nesting.

---

## 4. FRONTEND VIEWS

### A. Fetcher Registration Form
**File:** `application/views/students/fetch_registration.php`

**Form fields posted:**
```
POST to students/fetcher_id_submit
{
  "fetcher": [
    {                          // Index 0 — REQUIRED
      "firstname": "",
      "middlename": "",
      "lastname": "",
      "relationship": "",      // Father/Mother/Guardian/etc
      "contact_number": ""
    },
    {                          // Index 1 — OPTIONAL
      "firstname": "",
      ...
    }
  ],
  "student": [
    {                          // Index 0 — first student (REQUIRED)
      "fullname": "",
      "grade": "",             // K1, K2, Grade 1-12
      "section": ""
    },
    ...                       // Additional students via "Add another kid"
  ],
  "notes": ""
}
```

**Frontend validation:**
- Fetcher 1: firstname, lastname, relationship, contact_number required
- Student 1: fullname, grade, section required
- Others: optional
- Checkbox must be checked before submit

### B. Fetcher Information List (Admin View)
**File:** `application/views/students/fetcher_info.php` (new)

**Displays:** Table with columns:
- No. (row number)
- Application No. (`id` from DB)
- Fetchers (comma-separated: "Maria Rustila, Juan Dela Cruz")
- Students (comma-separated: "Juan Dela Cruz, Maria Dela Cruz")
- Date Registered (formatted: "Apr 18, 2025")
- Action → "View/Print" button (opens `students/fetcher_print/{id}` in new tab)

**Accessible URLs:**
- `students/fetcher_register` — new application form (all roles)
- `students/fetcher_list` — parent view (only shows their children's applications — not implemented in admin view)
- `students/fetcher_info` — **admin view** (all applications)

### C. Print View (ID Card)
**File:** `application/views/students/fetch_registration_print.php`

**Data decoding:**
```php
$fetcher_data = json_decode($record->fetcher_data, true);  // → array
$student_data = json_decode($record->student_data, true);  // → array
```

**Display logic:**
- Shows **exactly 2 fetcher slots** (top section) — fills empty slots with blank name boxes
- Shows **all students** in bottom 2-column grid
- Uses `getFullName()` helper: checks `fullname` first, then concats `firstname + middlename + lastname`
- Application number padded: `001`, `002`, etc.

**Logo updated:**
- Old: hardcoded "BHC" text inside blue circle
- New: `<img src="<?=base_url()?>assets/images/logo_portal.png">` (system logo)

---

## 5. MENU / SIDEBAR ACCESS CONTROL

**File:** `application/views/menu.php` (added lines 169–176)

```php
<?php if(in_array($this->session->userdata('current_usertype'), 
    array('Admin','Accounting','Registrar','Principal'))): ?>
<li class="nav-item">
  <a class="nav-link" href="<?=site_url("students/fetcher_info")?>">
    <i class="menu-icon typcn typcn-credit-card"></i>
    <span class="menu-title">Fetcher Information</span>
  </a>
</li>
<?php endif; ?>
```

**Placement:** After "Interview Schedules" and before "Payments" (Accounting-only) in the non-Parent/Teacher menu tree.

**Effective types mapping:**
- `Super Admin` → effective type `Admin` (Login_model line 114) → **has access**
- `Admin` → **has access**
- `Accounting` → **has access**
- `Registrar` → **has access**
- `Principal` → **has access**
- `Teacher` → no
- `Parent` → no (they use `fetcher_list` instead)
- `Student` → no

---

## 6. PRINCIPAL ACCOUNT CREATION SCRIPT

**File:** `create_principal.php` (root directory — DELETE AFTER USE)

**What it does:**
- Checks if Principal exists in `register` table
- If exists: resets password to `Pr1nc1p@l2025` (MD5: `dfaf98ecfef882b340e211b8b2b63b2b`)
- If not: creates new Principal with:
  - `mobileno`: `priscilla`
  - `emailadd`: `principal@bhca.edu.ph`
  - `firstname`: Maria
  - `middlename`: Santos
  - `lastname`: Rustila
  - `usertype`: Principal
  - `status`: 1 (active)
  - `deleted`: 'no'
  - `userpass`: MD5('Pr1nc1p@l2025')

**SQL executed by script:**
```sql
-- Check existence
SELECT * FROM `register` WHERE `usertype` = 'Principal' AND `deleted` = 'no';

-- If exists: reset password
UPDATE `register`
SET `userpass` = 'dfaf98ecfef882b340e211b8b2b63b2b',
    `lastlogin` = NOW()
WHERE `usertype` = 'Principal' AND `deleted` = 'no';

-- If not exists: insert
INSERT INTO `register` (
    `mobileno`, `emailadd`, `firstname`, `middlename`, `lastname`,
    `birthdate`, `userpass`, `usertype`, `gradelevel`, `gradelevel1`,
    `dateadded`, `lastlogin`, `deleted`, `status`, `lrn`, `school_id`
) VALUES (
    'priscilla', 'principal@bhca.edu.ph', 'Maria', 'Santos', 'Rustila',
    '1980-01-15', 'dfaf98ecfef882b340e211b8b2b63b2b', 'Principal',
    'N/A', 'N/A', NOW(), NOW(), 'no', 1, '', ''
);
```

---

## 7. EXISTING PRINCIPAL ACCOUNT (ALREADY IN DATABASE)

**From `Sql/myDB.sql` (line ~11897):**

| Field | Value |
|-------|-------|
| `id` | 86 |
| `mobileno` | `priscilla` |
| `emailadd` | *(empty)* |
| `firstname` | Priscilla |
| `middlename` | *(empty)* |
| `lastname` | Rustila |
| `usertype` | Principal |
| `status` | 1 (active) |
| `deleted` | no |
| `userpass` | `a9ec7e80d23264db4eec76f920117ce4` (MD5 of original password) |

**Login method:** Use **Phone** login (not Email) → identifier: `priscilla`

**Password:** Reset to `Pr1nc1p@l2025` using the script above.

---

## 8. ALL SQL QUERIES USED BY FEATURE

### Select
```sql
-- Get single application for printing
SELECT * FROM fetcher_registration WHERE id = ? LIMIT 1;

-- List all applications (admin)
SELECT * FROM fetcher_registration ORDER BY registered_date DESC;

-- List parent's applications (existing fetcher_list uses model, filter by user_id NOT implemented)
-- Note: fetcher_list currently shows ALL records — no parent filtering.
```

### Insert
```sql
INSERT INTO fetcher_registration (
    fetcher_data, student_data, notes, registered_date
) VALUES (
    '[{"firstname":"Maria","middlename":"S","lastname":"Rustila","relationship":"Mother","contact_number":"09951234567"},...]',
    '[{"fullname":"Juan Dela Cruz","grade":"Grade 3","section":"A"}]',
    'Please call before fetching',
    '2025-04-18 15:30:00'
);
```

### Update (none for this feature — registrations are immutable)
### Delete (none — soft-delete not implemented; records are permanent)

---

## 9. AUTHENTICATION FLOW

**Login uses `login_model->can_login($type, $identifier, $password)`** which:

1. Validates `$type` ∈ {`lrn`, `school_id`, `email`, `mobile`}
2. Looks up user in `register` table where:
   - `userpass` = `md5($password)`
   - `status` = 1
   - Filter by identifier column:
     - `email` → `emailadd` = ?
     - `mobile` → `mobileno` = ?
     - `lrn`/`school_id` → resolves via `students` table → `user_id` → `register.id`
3. On success:
   - Sets session: `current_usertype` (effective), `current_usertype_display` (raw), `current_userid`, etc.
   - Redirects to `dashboard`

**Principal login example:**
```
Type: mobile
Identifier: priscilla
Password: Pr1nc1p@l2025
Result: md5('Pr1nc1p@l2025') = 'dfaf98ecfef882b340e211b8b2b63b2b'
WHERE userpass='dfaf98ecfef882b340e211b8b2b63b2b' AND mobileno='priscilla' AND status=1
```

---

## 10. FILES CHANGED/CREATED

| File | Type | Change |
|------|------|--------|
| `Sql/fetcher_registration.sql` | New | Schema for fetcher_registration table |
| `application/views/students/fetch_registration.php` | Existing | Form for submitting applications |
| `application/views/students/fetcher_info.php` | New | Admin list view |
| `application/views/students/fetch_registration_print.php` | Existing | Print view (logo updated) |
| `application/views/menu.php` | Existing | Added Fetcher Information menu item |
| `application/controllers/Students.php` | Existing | Added `fetcher_info()` method; modified `fetcher_print()` |
| `application/models/Students_model.php` | Existing | Already had `fetcher_register()`, `get_fetcher_registration()`, `fetcher_registration_list()` |
| `create_principal.php` | New | Principal account setup script (DELETE AFTER USE) |

---

## 11. KNOWN ISSUES / NOTES

### ⚠️ Parent Filtering Not Implemented in `fetcher_info`
The `fetcher_info()` admin view correctly shows **all** applications. However, the existing `fetcher_list()` (parent view) does NOT filter by parent — it shows all records (same query as admin). If you need parent-specific filtering, that would require schema changes (link `fetcher_registration` to `user_id` or `student_id`).

### ⚠️ No Deleting/Editing
Applications are immutable once submitted. If you need edit/delete functionality, add `deleted` flag and `updated_date` columns.

### 📝 "Referred By" Field
**Currently NOT implemented.** The form only collects:
- Fetcher info (2 people max)
- Student info (unlimited)
- Notes

If you want to track **who referred the parent** (e.g., another parent, staff member), add a column:
```sql
ALTER TABLE fetcher_registration ADD COLUMN referred_by VARCHAR(100) NULL;
-- Options: 'Staff_Name', 'Parent_Name', 'Website', 'Facebook', etc.
```
Then add a dropdown/input to `fetch_registration.php` and include it in the `$data` insert array.

---

## 12. TESTING CHECKLIST

- [ ] Run `Sql/fetcher_registration.sql` in phpMyAdmin (if not already run)
- [ ] Access `students/fetcher_register` as Parent → submit test app → redirected to print view
- [ ] Verify logo appears in print view (not "BHC")
- [ ] Access `students/fetcher_info` as Admin/Accounting/Registrar/Principal → see full list
- [ ] Click "View/Print" in list → opens clean print page
- [ ] Test unauthorized access: login as Parent → try to access `students/fetcher_info` → should see 403 error
- [ ] Reset Principal password via `create_principal.php` → login as Principal → verify menu item visible
- [ ] Test print layout: browser print preview → no cut-offs, logo visible, page-break correct

---

## 13. QUICK REFERENCE: USER TYPES IN SYSTEM

From database inspection (`register.usertype` values):
- `Parent` – has access to Child management, Fetcher's ID Application (apply only)
- `Teacher` – My Students
- `Accounting` – Payments + Fetcher Information
- `Registrar` – Students management + Fetcher Information
- `Principal` – Fetcher Information (and possibly others)
- `Admin` / `Super Admin` – full access including Fetcher Information
- `Student` – limited portal access

---

**Last updated:** 2025-04-18  
**Feature status:** ✅ Deployed – Admin/Staff ready to print Fetcher IDs
