<?php

namespace App\Http\Controllers;

use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Project;

class ProjectCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = ProjectCategory::latest()->get();
        
        $bladeToReload = $request->query('bladeFileToReload');
        switch ($bladeToReload) {
            case 'categoryIndexTable':
                return view('projects.categories.category-component', [
                    'categories' => $categories,
                ]);
            default:
                return view('projects.category-index', [
                    'categories' => $categories,
                ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_category_name' => 'required|string|max:255|unique:project_categories,name',
        ]);

        $projectCategory = ProjectCategory::create([
            'name' => $request->project_category_name,
            'created_by' => Auth::user()->id
        ]);

        if (isset($request->category_page) && !empty($request->category_page)) {
            return response()->json([
                'success' => true,
                'reload' => true,
                'componentId' => 'categoryIndexTable',
                'refresh' => false,
                'message' => __('Project Category Created Successfully'),
                'redirect' => route('project_categories.index'),
            ]);
        }


        return response()->json(['success' => true, 'project_category' => $projectCategory]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectCategory $projectCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectCategory $projectCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectCategory $projectCategory)
    {
        $request->validate([
            'project_category_name' => [
                'required',
                'max:255',
                Rule::unique('project_categories', 'name')->ignore($projectCategory->id),
            ],
        ]);

        $projectCategory->update([
            'name' => $request->project_category_name,
            'created_by' => Auth::user()->id
        ]);

        return response()->json([
            'success' => true,
            'reload' => true,
            'componentId' => 'categoryIndexTable',
            'refresh' => false,
            'message' => __('Project Category Created Successfully'),
            'redirect' => route('project_categories.index'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectCategory $projectCategory)
    {
        $category_to_project = Project::where('projectCategoryId', $projectCategory->id)->first();
        if ($category_to_project) {
            return response()->json([
                'success' => false,
                'message' => __('This Category Is Still Attached to a project!'),
            ]);
        }

        if ($projectCategory->isActive === 1) {
            return response()->json([
                'success' => false,
                'message' => __('This Category Is Still Active!'),
            ]);
        }

        $projectCategory->delete();
        return response()->json([
            'success' => true,
            'reload' => true,
            'componentId' => 'categoryIndexTable',
            'refresh' => false,
            'message' => __('Project Category Deleted Successfully'),
            'redirect' => route('project_categories.index'),
        ]);
    }


    
    public function changeCategoryStatus(Request $request, $id) 
    {
        // Validate the request data for status
        $validated = $request->validate([
            'status' => 'required|in:1,0',  // Ensures only 'active' or 'inactive' are allowed
        ]);
    
        // Find the user by ID
        $projectCategory = ProjectCategory::find($id);
    
        if ($projectCategory) {
            $projectCategory->isActive = $validated['status']; 
            if ($projectCategory->save()) {  // Save the user object
                return response()->json([
                    'success' => true,
                    'reload' => true,
                    'componentId' => 'categoryIndexTable',
                    'refresh' => false,
                    'message' => __('Project Category Updated Successfully'),
                    'redirect' => route('project_categories.index'),
                ]);
            }
        }
    
        // If user not found or status update failed
        return response()->json([
            'success' => false,
            'message' => __('Project Category not found or status update failed!'),
        ]);
    }
    
}
