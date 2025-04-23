<?php

namespace App\Http\Controllers;

use App\Models\LessonPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LessonPackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LessonPackage::query();

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(lesson_package_name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(lesson_package_description) LIKE ?', ["%{$search}%"]);
            });
        }

        $lessonPackages = $query->paginate(10)->appends(['search' => $request->search]);

        return view('lesson_package.index', compact('lessonPackages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lesson_package.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lesson_package_name' => 'required|string|max:100',
            'lesson_package_description' => 'nullable|string|max:255',
            'lesson_duration' => 'required|integer|min:1',
            'lesson_package_price' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            LessonPackage::create([
                'lesson_package_name' => $request->lesson_package_name,
                'lesson_package_description' => $request->lesson_package_description,
                'lesson_duration' => $request->lesson_duration,
                'lesson_package_price' => $request->lesson_package_price,
                'created_by' => Auth::user()->user_id,
            ]);

            DB::commit();
            return redirect()->route('lesson-package-index')->with('success', 'Lesson Package created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create lesson package.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $lessonPackage = LessonPackage::findOrFail($id);
        return view('lesson_package.edit', compact('lessonPackage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'lesson_package_name' => 'required|string|max:100',
            'lesson_package_description' => 'nullable|string|max:255',
            'lesson_duration' => 'required|integer|min:1',
            'lesson_package_price' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            LessonPackage::where('lesson_package_id', $id)->update([
                'lesson_package_name' => $request->lesson_package_name,
                'lesson_package_description' => $request->lesson_package_description,
                'lesson_duration' => $request->lesson_duration,
                'lesson_package_price' => $request->lesson_package_price,
                'updated_by' => Auth::user()->user_id,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            DB::commit();
            return redirect()->route('lesson-package-index')->with('success', 'Lesson Package updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to update lesson package.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $lessonPackage = LessonPackage::findOrFail($id);
            $lessonPackage->delete();

            DB::commit();
            return redirect()->route('lesson-package-index')
                ->with('success', 'Lesson Package deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to delete lesson package.');
        }
    }
}
