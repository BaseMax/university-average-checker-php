# University Average Checker (PHP)

A simple PHP script to compute and verify university semester and cumulative averages from a transcript. It checks each semester's calculated average against stored data, skipping withdrawn semesters, and updates the cumulative average after each term.

---

## Features

- Computes semester averages from course grades and units.
- Skips withdrawn semesters (all grades zero).
- Checks calculated averages against stored semester averages (`term_avg`).
- Calculates cumulative total average step by step.
- Highlights discrepancies between calculated and recorded averages.

---

## Installation

1. Clone the repository:

```bash
git clone https://github.com/BaseMax/university-average-checker-php.git
cd university-average-checker-php
````

2. Copy the example configuration file:

```bash
cp config.example.php config.php
```

3. Edit `config.php` to include your transcript data.

---

## Usage

Run the checker script from the command line:

```bash
php check.php
```

You will see output like:

```
📘 Semester-wise report:

1398-1397 - ترم اول:
  Calculated = 20.00 | Units = 15 | Stored term_avg = 20.00
  ✅ Semester average matches stored value
  🔹 Temporary cumulative average after this semester = 20.00

📊 Final cumulative average = 20.00
✅ Cumulative average matches stored value
```

---

## Configuration Example

```php
<?php
$transcript = [
    [
        "year" => "1398-1397",
        "semester" => "اول",
        "courses" => [
            ["code" => "93107", "name" => "فارسی عمومی", "units" => 3, "grade" => 20.00],
            ["code" => "93125", "name" => "اخلاق اسلامی (مبانی و مفاهیم)", "units" => 2, "grade" => 20.00],
            ["code" => "110100", "name" => "ریاضی مقدماتی", "units" => 4, "grade" => 20.00],
            ["code" => "110221", "name" => "مبانی ریاضی", "units" => 3, "grade" => 20.00],
            ["code" => "111702", "name" => "مبانی ترکیبیات", "units" => 3, "grade" => 20.00],
        ],
        "term_units_taken" => 15,
        "term_units_passed" => 15,
        "term_avg" => 20.00,
        "total_units_taken" => 15,
        "total_units_passed" => 15,
        "total_avg" => 20.00,
    ],
];
```

> Make sure to adjust grades, units, and semesters according to your actual transcript.

---

## License

This project is licensed under the MIT License.

© 2025 Seyyed Ali Mohammadiyeh (Max Base)
