<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['event'])->latest()->get();
        $events = Event::orderBy('name')->get(['id', 'name']);
        $statuses = [
            Payment::STATUS_PENDING,
            Payment::STATUS_CHECKING,
            Payment::STATUS_VALID,
            Payment::STATUS_REJECTED,
        ];
        $viewData = [
            'title' => 'Payments',
            'payments' => $payments,
            'events' => $events,
            'statuses' => $statuses,
        ];
        return view('admin.payments.index', $viewData);
    }

    public function show(Payment $payment)
    {
        $payment->load(['event']);
        $declineReasons = Payment::getDeclineReasons();
        $viewData = [
            'title' => 'Payment Details',
            'payment' => $payment,
            'declineReasons' => $declineReasons,
        ];
        return view('admin.payments.show', $viewData);
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', [
                Payment::STATUS_PENDING,
                Payment::STATUS_CHECKING,
                Payment::STATUS_VALID,
                Payment::STATUS_REJECTED
            ])],
            'decline_reason' => ['nullable', 'required_if:status,' . Payment::STATUS_REJECTED, 'string'],
            'custom_reason' => ['nullable', 'required_if:decline_reason,Lainnya', 'string'],
            'proof_of_payment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:4096'],
        ]);

        try {
            DB::beginTransaction();

            $payment->status = $validated['status'];
            if ($validated['status'] === Payment::STATUS_REJECTED) {
                $payment->decline_reason = $validated['decline_reason'] === 'Lainnya'
                    ? $validated['custom_reason']
                    : $validated['decline_reason'];
            } else {
                $payment->decline_reason = null;
            }
            // Handle proof of payment upload
            if ($request->hasFile('proof_of_payment')) {
                $destinationPath = public_path('image/proof_of_payments');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true);
                }

                // Remove old file if exists
                if (!empty($payment->proof_of_payment)) {
                    $oldPath = $destinationPath . DIRECTORY_SEPARATOR . $payment->proof_of_payment;
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                $uploadedFile = $request->file('proof_of_payment');
                $filename = 'proof_' . $payment->id . '_' . time() . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move($destinationPath, $filename);
                $payment->proof_of_payment = $filename;
            }

            $payment->save();

            DB::commit();

            return redirect()->route('payments.index', $payment)
                ->with('success', 'Status pembayaran berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui status pembayaran.')
                ->withInput();
        }
    }

    public function destroy(Payment $payment)
    {
        try {
            DB::beginTransaction();
            // Delete file if exists
            if (!empty($payment->proof_of_payment)) {
                $path = public_path('image/proof_of_payments/' . $payment->proof_of_payment);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            $payment->delete();
            DB::commit();

            return redirect()->route('payments.index')
                ->with('success', 'Pembayaran berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus pembayaran.');
        }
    }
}
