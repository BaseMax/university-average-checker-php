<?php
// -*- coding: utf-8 -*-
// Compute semester and total averages from fixed grade data.
// Compare calculated semester averages with term_avg in transcript.
// Skip semesters where all course grades are zero (withdrawn semesters).
// Update and print cumulative total average after each semester.
// Author: Max Base

require_once __DIR__ . '/config.php';

function is_withdrawn_semester($semester)
{
    foreach ($semester['courses'] as $course) {
        if ($course['grade'] != 0) {
            return false;
        }
    }
    return true;
}

function calc_semester_average($semester)
{
    $total_weighted = 0;
    $total_units = 0;

    foreach ($semester['courses'] as $course) {
        $total_weighted += $course['grade'] * $course['units'];
        $total_units += $course['units'];
    }

    $avg = ($total_units > 0) ? $total_weighted / $total_units : 0;
    return [$avg, $total_units];
}

function print_results($transcript)
{
    echo "📘 گزارش معدل‌ها و اعتبارسنجی مرحله‌به‌مرحله:\n\n";

    $cumulative_weighted = 0;
    $cumulative_units = 0;

    foreach ($transcript as $sem) {
        if (is_withdrawn_semester($sem)) {
            echo "{$sem['year']} - ترم {$sem['semester']}: ⚠️ ترم حذف شده، نادیده گرفته شد\n\n";
            continue;
        }

        list($avg, $units) = calc_semester_average($sem);
        echo "{$sem['year']} - ترم {$sem['semester']}:\n";
        echo "  محاسبه شده = " . round($avg, 2) . " | واحد = $units | term_avg موجود = {$sem['term_avg']}\n";

        if (abs($avg - $sem['term_avg']) > 0.001) {
            echo "  ⚠️ خطا: معدل ترم محاسبه شده با مقدار ذخیره شده مطابقت ندارد!\n";
        } else {
            echo "  ✅ تطابق معدل ترم با داده ذخیره شده.\n";
        }

        $cumulative_weighted += $avg * $units;
        $cumulative_units += $units;
        $cumulative_avg = ($cumulative_units > 0) ? $cumulative_weighted / $cumulative_units : 0;

        echo "  🔹 معدل کل موقت پس از این ترم = " . round($cumulative_avg, 2) . "\n\n";
    }

    $final_avg = ($cumulative_units > 0) ? $cumulative_weighted / $cumulative_units : 0;
    echo "📊 معدل کل نهایی محاسبه شده = " . round($final_avg, 2) . "\n";

    $non_withdrawn = array_filter($transcript, fn($s) => !is_withdrawn_semester($s));
    if (!empty($non_withdrawn)) {
        $last = end($non_withdrawn);
        $last_total_avg = $last['total_avg'];

        if (abs($final_avg - $last_total_avg) > 0.001) {
            echo "⚠️ خطا: معدل کل محاسبه شده با مقدار ذخیره شده مطابقت ندارد!\n";
        } else {
            echo "✅ معدل کل مطابقت دارد.\n";
        }
    }
}

print_results($transcript);
