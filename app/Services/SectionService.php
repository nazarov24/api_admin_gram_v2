<?php

namespace App\Services;

use App\Http\Requests\SectionRequest;
use App\Models\Role;
use App\Models\Section;
use App\Models\Subsection;
use App\Models\User;
use Illuminate\Http\Request;

class SectionService
{

    public static function index()
    {
        $sections = Section::with('subsections')->orderBy('title', 'desc')->get();

        $sections->transform(function ($section) {

            $users = User::whereHas('roles.sections', function ($query) use ($section) {
                $query->where('sections.id', $section->id);
            })->get();

            $section->users = $users->map(function ($user) {
                return [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'roles' => $user->roles->pluck('name'),
                    'permissions' => $user->getAllPermissions()->pluck('name'),
                ];
            });

            $section->subsections->transform(function ($subsection) {
                $subsectionUsers = User::whereHas('roles.subsections', function ($query) use ($subsection) {
                    $query->where('subsections.id', $subsection->id);
                })->get();

                $subsection->users = $subsectionUsers->map(function ($user) {
                    return [
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'roles' => $user->roles->pluck('name'),
                        'permissions' => $user->getAllPermissions()->pluck('name'),
                    ];
                });

                return $subsection;
            });

            return $section;
        });

        return $sections;

        
    }


    public static function store(SectionRequest $request)
    {
        $section = Section::create([
            'title' => $request->title,
            'icon' => $request->icon,
        ]);

        $subsections = collect($request->subsections)->map(function ($subsection) use ($section) {
            return new Subsection([
                'title' => $subsection['title'],
                'component_id' => $subsection['component_id'],
                'section_id' => $section->id,
            ]);
        });

        $section->subsections()->saveMany($subsections);

        return $section;
    }


    public static function update(SectionRequest $request, $id)
    {
        $section = Section::find($id);

        if (!$section) {
            return response()->json(['message' => 'Раздел не найден'], 404);
        }

        $section->update([
            'title' => $request->title,
            'icon' => $request->icon,
        ]);

        $currentSubsectionIds = $section->subsections()->pluck('id')->toArray();
        $newSubsectionTitles = [];

        foreach ($request->subsections as $subsectionData) {
            $subsection = $section->subsections()
                ->where('title', $subsectionData['title'])
                ->first();

            if ($subsection) {
                $subsection->update([
                    'component_id' => $subsectionData['component_id'],
                ]);
                $currentSubsectionIds = array_diff($currentSubsectionIds, [$subsection->id]);
            } else {
                $newSubsection = $section->subsections()->create([
                    'title' => $subsectionData['title'],
                    'component_id' => $subsectionData['component_id'],
                ]);
                $newSubsectionTitles[] = $newSubsection->title;
            }
        }


        if (!empty($currentSubsectionIds)) {
            $section->subsections()->whereIn('id', $currentSubsectionIds)->delete();
        }

        return response()->json([
            'message' => 'Раздел и подразделы обновлены',
            'new_subsections' => $newSubsectionTitles,
            'section' => $section->load('subsections'),
        ]);
    }


    public static function destroy($id)
    {
        $section = Section::find($id);

        if (!$section) {
            return ['message' => 'Раздел не найден'];
        }

        $section->subsections()->delete();

        $section->delete();

        return ['message' => "Раздел удалена"];

    }

}