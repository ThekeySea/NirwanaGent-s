<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barber;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index()
    {
        return view('pages.admin.services-index', [
            'services' => Service::orderBy('name')->paginate(20),
        ]);
    }

    public function create()
    {
        return view('pages.admin.services-form', [
            'service' => new Service(['is_active' => true]),
            'barbers' => Barber::orderBy('name')->get(),
            'selected' => [],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $service = Service::create($validated);
        $service->barbers()->sync($request->input('barbers', []));

        return redirect('/admin/services')->with('status', $service->name.' tersimpan.');
    }

    public function edit(int $id)
    {
        $service = Service::findOrFail($id);

        return view('pages.admin.services-form', [
            'service' => $service,
            'barbers' => Barber::orderBy('name')->get(),
            'selected' => $service->barbers()->pluck('barbers.id')->all(),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $service = Service::findOrFail($id);
        $validated = $this->validateData($request, $service->id);

        $service->update($validated);
        $service->barbers()->sync($request->input('barbers', []));

        return redirect('/admin/services')->with('status', $service->name.' diperbarui.');
    }

    public function destroy(int $id)
    {
        $service = Service::findOrFail($id);

        if ($service->barbers()->exists() || Booking::where('service_id', $service->id)->exists()) {
            return back()->withErrors(['service' => 'Tidak bisa hapus: masih terhubung ke barber atau booking. Nonaktifkan saja.']);
        }

        $service->delete();

        return redirect('/admin/services')->with('status', 'Service dihapus.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('services', 'slug')->ignore($ignoreId)],
            'description' => ['nullable', 'string', 'max:2000'],
            'inclusions' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'integer', 'min:0', 'max:100000000'],
            'duration_minutes' => ['required', 'integer', 'min:5', 'max:480'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'barbers' => ['nullable', 'array'],
            'barbers.*' => ['integer', 'exists:barbers,id'],
        ]);

        $validated['slug'] = ($validated['slug'] ?? null) ?: Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        unset($validated['barbers']);

        return $validated;
    }
}
