<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Gate;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response //ให้indexเพิ่มresponse
    {
        return Inertia::render('Chirps/Index', [
            'chirps' => Chirp::with('user:id,name')->latest()->get(), //render แล้วเอาข้อมูลจาฐานข้อมูลมาด้วย
        ]);
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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]); //ตรวจสอบข้อมูลที่เข้ามา

        $request->user()->chirps()->create($validated); //ดึงข้อมูลผู้ใช้ปัจจุบันที่ล็อกอินอยู่->เรียกความสัมพันธ์ใน User Model เพื่อเพิ่มข้อมูลไปยัง chirps ที่เชื่อมกับผู้ใช้นั้น->สร้างข้อความใหม่ในตาราง chirps

        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp):RedirectResponse
    {
        Gate::authorize('update', $chirp); //ตรวจสอบสิทในการแก้ไข

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated); //อัพเดตข้อความ

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete', $chirp);

        $chirp->delete(); //ลบขอ้มูล

        return redirect(route('chirps.index'));
    }
}
