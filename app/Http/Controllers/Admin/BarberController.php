<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BarberController extends Controller
{
    public function index()
    {
        return view('pages.admin.barbers-index', [
            'barbers' => Barber::orderBy('name')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('pages.admin.barbers-form', [
            'barber' => new Barber(['is_active' => true, 'role' => 'Barber']),
            'services' => Service::orderBy('name')->get(),
            'selected' => [],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $barber = Barber::create($validated);
        $barber->services()->sync($request->input('services', []));

        return redirect('/admin/barbers')->with('status', $barber->name.' tersimpan.');
    }

    public function edit(int $id)
    {
        $barber = Barber::findOrFail($id);

        return view('pages.admin.barbers-form', [
            'barber' => $barber,
            'services' => Service::orderBy('name')->get(),
            'selected' => $barber->services()->pluck('services.id')->all(),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $barber = Barber::findOrFail($id);
        $validated = $this->validateData($request, $barber->id);

        $barber->update($validated);
        $barber->services()->sync($request->input('services', []));

        return redirect('/admin/barbers')->with('status', $barber->name.' diperbarui.');
    }

    public function destroy(int $id)
    {
        $barber = Barber::findOrFail($id);

        if (Booking::where('barber_id', $barber->id)->exists()) {
            return back()->withErrors(['barber' => 'Tidak bisa hapus: masih punya booking. Nonaktifkan saja.']);
        }

        $barber->services()->detach();
        $barber->delete();

        return redirect('/admin/barbers')->with('status', 'Barber dihapus.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('barbers', 'slug')->ignore($ignoreId)],
            'role' => ['required', 'string', 'max:50'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'specialties' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'services' => ['nullable', 'array'],
            'services.*' => ['integer', 'exists:services,id'],
        ]);

        $validated['slug'] = ($validated['slug'] ?? null) ?: Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        unset($validated['services']);

        return $validated;
    }
}
