<?php

use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/teacher/dashboard', [App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('teacher.dashboard');
    Route::get('/registrar/dashboard', [App\Http\Controllers\Registrar\DashboardController::class, 'index'])->name('registrar.dashboard');
    Route::get('/student/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('student.dashboard');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('sections', App\Http\Controllers\Admin\SectionController::class);
});

Route::resource('students', App\Http\Controllers\Admin\StudentController::class);


Route::middleware(['auth'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Teacher\DashboardController::class, 'index'])
        ->name('dashboard');
});

Route::middleware(['auth', 'role:Teacher'])->prefix('teacher')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Teacher\DashboardController::class, 'index'])
        ->name('teacher.dashboard');
});


Route::middleware(['auth', 'role:Student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])
            ->name('dashboard');
    });


    Route::middleware(['auth', 'role:Teacher'])
    ->prefix('teacher/attendance')
    ->name('teacher.attendance.')
    ->group(function () {
        Route::get('/', [App\Http\Controllers\Teacher\AttendanceController::class, 'index'])->name('index');
        Route::get('/{section}/create', [App\Http\Controllers\Teacher\AttendanceController::class, 'create'])->name('create');
        Route::post('/{section}', [App\Http\Controllers\Teacher\AttendanceController::class, 'store'])->name('store');
    });


    Route::middleware(['auth', 'role:Teacher'])
    ->prefix('teacher/grades')
    ->name('teacher.grades.')
    ->group(function () {
        Route::get('/{section}', [App\Http\Controllers\Teacher\GradeController::class, 'index'])
            ->name('index');
        Route::post('/{section}', [App\Http\Controllers\Teacher\GradeController::class, 'store'])
            ->name('store');
    });

    Route::get('/grades', [App\Http\Controllers\Student\DashboardController::class, 'grades'])
    ->name('grades');

Route::middleware(['auth', 'role:Student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/report-card', 
            [App\Http\Controllers\Student\ReportCardController::class, 'index']
        )->name('report.card');
    });


Route::prefix('registrar')->name('registrar.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Registrar\DashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('teacher')->name('teacher.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('student')->name('student.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
});




// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\SectionController;

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Students Management
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

    // Teachers Management
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    // Sections Management
    Route::get('/sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('/sections/create', [SectionController::class, 'create'])->name('sections.create');
    Route::post('/sections', [SectionController::class, 'store'])->name('sections.store');
    Route::get('/sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('/sections/{section}', [SectionController::class, 'update'])->name('sections.update');
    Route::delete('/sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy');

});


Route::get('/admin/dashboard/stats', function () {
    return response()->json([
        'students' => \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'student'))->count(),
        'teachers' => \App\Models\User::whereHas('role', fn($q) => $q->where('name', 'teacher'))->count(),
        'sections' => \App\Models\Section::count(),
    ]);
})->middleware(['auth']);

Route::get('/admin/dashboard/stats', [App\Http\Controllers\Admin\DashboardController::class, 'getStats'])->name('admin.dashboard.stats');

Route::put('/admin/sections/{section}/assign-teacher',
    [SectionController::class, 'assignTeacher'])->name('sections.assignTeacher');

Route::get('/admin/sections/{section}/students',
    [SectionController::class, 'students'])->name('sections.students');

use App\Http\Controllers\ExportController;

Route::get('/admin/export/teacher/{id}', [ExportController::class, 'teacher'])
    ->name('export.teacher');





Route::prefix('admin')->name('sections.')->middleware(['auth'])->group(function () {
    Route::post('/assign-teacher-bulk/{teacher}', [App\Http\Controllers\Admin\SectionController::class, 'assignTeacherBulk'])
         ->name('assignTeacherBulk');
});





require __DIR__.'/auth.php';
