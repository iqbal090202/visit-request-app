<template>
    <div>
        <p style="color: red">{{ error }}</p>

        <p>
            Last result: <b>{{ result }}</b>
        </p>

        <div style="border: 2px solid black" class="m-5 h-[500px]">
            <qrcode-stream
                :paused="paused"
                :track="paintBoundingBox"
                @detect="onDetect"
                @error="onError"
            ></qrcode-stream>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { QrcodeStream } from "vue-qrcode-reader";

const result = ref("");
const error = ref("");
const loading = ref(false);
const paused = ref(false);

function paintBoundingBox(detectedCodes, ctx) {
    for (const detectedCode of detectedCodes) {
        const {
            boundingBox: { x, y, width, height },
        } = detectedCode;

        ctx.lineWidth = 2;
        ctx.strokeStyle = "#007bff";
        ctx.strokeRect(x, y, width, height);
    }
}

function onError(err) {
    error.value = `[${err.name}]: `;

    if (err.name === "NotAllowedError") {
        error.value += "you need to grant camera access permission";
    } else if (err.name === "NotFoundError") {
        error.value += "no camera on this device";
    } else if (err.name === "NotSupportedError") {
        error.value += "secure context required (HTTPS, localhost)";
    } else if (err.name === "NotReadableError") {
        error.value += "is the camera already in use?";
    } else if (err.name === "OverconstrainedError") {
        error.value += "installed cameras are not suitable";
    } else if (err.name === "StreamApiNotSupportedError") {
        error.value += "Stream API is not supported in this browser";
    } else if (err.name === "InsecureContextError") {
        error.value +=
            "Camera access is only permitted in secure context. Use HTTPS or localhost rather than HTTP.";
    } else {
        error.value += err.message;
    }
}

async function onDetect(detectedCodes) {
    const decodedText = detectedCodes[0].rawValue
    try {
        loading.value = true;
        const response = await fetch(`/api/check-qrcode`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: decodedText }),
        });
        const res = await response.json();

        paused.value = true
        await timeout(500)
        paused.value = false

        loading.value = false;
        if (response.status !== 200) {
            throw new Error(res.message);
        }
        result.value = res.message;
    } catch (error) {
        result.value = error;
    }
}

function timeout(ms) {
    return new Promise((resolve) => {
        window.setTimeout(resolve, ms)
    })
}
</script>

<style scoped>
.error {
    font-weight: bold;
    color: red;
}
.barcode-format-checkbox {
    margin-right: 10px;
    white-space: nowrap;
}
</style>
