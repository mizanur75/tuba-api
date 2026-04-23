<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::firstOrCreate([], [
            'site_name' => 'Admin Dashboard',
        ]);

        return view('settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::firstOrCreate([], [
            'site_name' => 'Admin Dashboard',
        ]);

        $data = $request->validate([
            'site_name' => 'required|string|max:150',
            'site_tagline' => 'nullable|string|max:255',
            'support_email' => 'nullable|email|max:150',
            'support_phone' => 'nullable|string|max:50',
            'office_address' => 'nullable|string|max:255',
            'footer_text' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'admin_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'admin_favicon' => 'nullable|mimes:ico,jpg,jpeg,png,webp|max:1024',
        ]);

        if ($request->hasFile('admin_logo')) {
            if ($setting->admin_logo && Storage::disk('public')->exists($setting->admin_logo)) {
                Storage::disk('public')->delete($setting->admin_logo);
            }

            $data['admin_logo'] = $request->file('admin_logo')->store('settings', 'public');
        }

        if ($request->hasFile('admin_favicon')) {
            if ($setting->admin_favicon && Storage::disk('public')->exists($setting->admin_favicon)) {
                Storage::disk('public')->delete($setting->admin_favicon);
            }

            $data['admin_favicon'] = $request->file('admin_favicon')->store('settings', 'public');
        }

        $setting->update($data);

        return redirect()->route('settings.edit')
            ->with('success', 'Settings updated successfully.');
    }
}
