<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
class ProjectController extends Controller
{
public function index()
{
return response()->json(
Project::where('status', 'published')->latest()->paginate(10)
);
}
public function show(Project $project)
{
abort_unless($project->status === 'published', 404);
return response()->json($project);
}
public function store(Request $request)
{
$data = $request->validate([
'title' => ['required', 'string', 'max:150'],
'category' => ['required', 'string', 'max:100'],
'description' => ['required', 'string'],
'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
'tech_stack' => ['nullable', 'array'],
'tech_stack.*' => ['string', 'max:50'],
'demo_url' => ['nullable', 'url'],
'github_url' => ['nullable', 'url'],
'is_featured' => ['sometimes', 'boolean'],
'status' => ['required', Rule::in(['draft', 'published'])],
]);
if ($request->hasFile('image')) {
$data['image'] = $request->file('image')->store('projects', 'public');
}
$base = Str::slug($data['title']);
$slug = $base;
$i = 1;
while (Project::where('slug', $slug)->exists()) {
$slug = $base . '-' . $i++;
}
$data['slug'] = $slug;
$project = Project::create($data);
return response()->json([
'message' => 'Project berhasil ditambahkan',
'data' => $project,
], 201);
}
public function update(Request $request, Project $project)
{
$data = $request->validate([
'title' => ['sometimes', 'required', 'string', 'max:150'],
'category' => ['sometimes', 'required', 'string', 'max:100'],
'description' => ['sometimes', 'required', 'string'],
'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
'tech_stack' => ['sometimes', 'nullable', 'array'],
'tech_stack.*' => ['string', 'max:50'],
'demo_url' => ['sometimes', 'nullable', 'url'],
'github_url' => ['sometimes', 'nullable', 'url'],
'is_featured' => ['sometimes', 'boolean'],
'status' => ['sometimes', 'required', Rule::in(['draft', 'published'])],
]);
if ($request->hasFile('image')) {
if ($project->image) {
Storage::disk('public')->delete($project->image);
}
$data['image'] = $request->file('image')->store('projects', 'public');
}
if (isset($data['title'])) {
$base = Str::slug($data['title']);
$slug = $base;
$i = 1;
while (
Project::where('slug', $slug)
->whereKeyNot($project->getKey())
->exists()
) {
$slug = $base . '-' . $i++;
}
$data['slug'] = $slug;
}
$project->update($data);
return response()->json([
'message' => 'Project berhasil diperbarui',
'data' => $project->fresh(),
]);
}
public function destroy(Project $project)
{
if ($project->image) {
Storage::disk('public')->delete($project->image);
}
$project->delete();
return response()->json(['message' => 'Project berhasil dihapus']);
}
}