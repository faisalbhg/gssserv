<div x-data="signaturePad(@entangle($attributes->wire('model')))">
    <h1 class="text-xl font-semibold text-gray-700 flex items-center justify-between"><span>Signature pad</span></h1>
    <div>
        <canvas x-ref="signature_canvas" class="border rounded shadow">

        </canvas>
    </div>
</div>