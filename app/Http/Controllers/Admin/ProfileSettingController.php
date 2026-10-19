<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileSettingController extends Controller
{
    public function edit()
    {
        $settingsRaw = ProfileSetting::all();
        $settings = [];
        foreach ($settingsRaw as $s) {
            $val = json_decode($s->value, true);
            $settings[$s->key] = json_last_error() === JSON_ERROR_NONE ? $val : $s->value;
        }

        return Inertia::render('Admin/Profile/Index', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', 'hero_image_file']);

        if ($request->hasFile('hero_image_file')) {
            $path = $request->file('hero_image_file')->store('profile', 'public');
            $data['hero_image'] = '/storage/'.$path;
        }

        foreach ($data as $key => $val) {
            ProfileSetting::setVal($key, $val);
        }

        return back()->with('success', 'Pengaturan profil berhasil diperbarui.');
    }
}
