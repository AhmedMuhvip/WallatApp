<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Create Transaction</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ✅ CSRF TOKEN (FIX) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-slate-50">
<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white rounded-2xl shadow p-6">
        <div class="flex items-center justify-between gap-3 mb-6">
            <h1 class="text-xl font-semibold text-slate-900">New Transaction</h1>
            <span class="text-xs px-2 py-1 rounded-full bg-slate-100 text-slate-600">Tailwind + JS</span>
        </div>

        <!-- Alert -->
        <div id="alert" class="hidden mb-4 rounded-xl border p-4 text-sm"></div>

        <!-- ✅ no need action/method since we use fetch -->
        <form id="txForm" class="space-y-5">
            <!-- Bank -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Bank Provider</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="flex items-center gap-3 rounded-xl border p-3 cursor-pointer hover:bg-slate-50">
                        <input type="radio" name="bank" value="PayTech" class="h-4 w-4" checked/>
                        <div>
                            <div class="font-medium text-slate-900">PayTech</div>
                            <div class="text-xs text-slate-500">Fast checkout flow</div>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 rounded-xl border p-3 cursor-pointer hover:bg-slate-50">
                        <input type="radio" name="bank" value="acme" class="h-4 w-4"/>
                        <div>
                            <div class="font-medium text-slate-900">Acme</div>
                            <div class="text-xs text-slate-500">Standard processing</div>
                        </div>
                    </label>
                </div>
            </div>
            <!-- Reference -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Reference / Order ID</label>
                <input
                    id="transaction_data"
                    type="text"
                    placeholder="ORD-2026-0001"
                    class="w-full rounded-xl border px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-300"
                    required
                />
                <p class="mt-1 text-xs text-slate-500">Use something unique per transaction.</p>
            </div>


            <!-- Button -->
            <div class="flex items-center justify-end gap-3">
                <button
                    type="button"
                    id="fillDemo"
                    class="rounded-xl border px-4 py-2.5 text-sm hover:bg-slate-50"
                >
                    Fill demo
                </button>

                <button
                    type="submit"
                    id="submitBtn"
                    class="rounded-xl bg-slate-900 text-white px-5 py-2.5 text-sm font-medium hover:bg-slate-800 disabled:opacity-60 disabled:cursor-not-allowed"
                >
                    Send Transaction
                </button>
            </div>
        </form>
    </div>

    <div class="text-xs text-slate-500 mt-4">
        Tip: open DevTools → Network to see the request payload.
    </div>
</div>

<script>
    const API_URL = "/webhook/transaction";

    const form = document.getElementById("txForm");
    const alertBox = document.getElementById("alert");
    const submitBtn = document.getElementById("submitBtn");

    function showAlert(type, message) {
        alertBox.classList.remove("hidden");
        alertBox.className = "mb-4 rounded-xl border p-4 text-sm";
        if (type === "success") {
            alertBox.classList.add("border-emerald-200", "bg-emerald-50", "text-emerald-800");
        } else if (type === "error") {
            alertBox.classList.add("border-rose-200", "bg-rose-50", "text-rose-800");
        } else {
            alertBox.classList.add("border-slate-200", "bg-slate-50", "text-slate-700");
        }
        alertBox.textContent = message;
    }

    function getSelectedBank() {
        return document.querySelector('input[name="bank"]:checked')?.value;
    }

    function getPayload() {
        return {
            bank: getSelectedBank(),
            transaction_data: document.getElementById("transaction_data").value.trim(),
        };
    }

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const payload = getPayload();
        submitBtn.disabled = true;
        showAlert("info", "Sending transaction...");

        try {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            const res = await fetch(API_URL, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrf,
                    "Accept": "application/json",
                },
                // ✅ IMPORTANT for web routes (session cookie)
                credentials: "same-origin",
                body: JSON.stringify(payload),
            });

            const data = await res.json().catch(() => null);

            if (!res.ok) {
                const msg =
                    data?.message ||
                    (data?.errors ? JSON.stringify(data.errors) : null) ||
                    `Request failed (${res.status})`;
                throw new Error(msg);
            }

            showAlert("success", "Transaction sent successfully ✅");
            console.log("Server response:", data);

        } catch (error) {
            showAlert("error", error.message || "Something went wrong.");
            console.error(error);
        } finally {
            submitBtn.disabled = false;
        }
    });

    document.getElementById("fillDemo").addEventListener("click", () => {
        document.querySelector('input[name="bank"][value="PayTech"]').checked = true;
        document.getElementById("transaction_data").value = "ORD-2026-0001";
        showAlert("info", "Demo data filled.");
    });
</script>
</body>
</html>
