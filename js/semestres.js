document.addEventListener("DOMContentLoaded", () => {

    const ciclo = window.CICLO_ACTUAL; // ← AQUÍ está el valor real
    const semestreSelect = document.getElementById("semestre");

    const opciones = {
        impar: [
            { value: "1", text: "I" },
            { value: "3", text: "III" },
            { value: "5", text: "V" }
        ],
        par: [
            { value: "2", text: "II" },
            { value: "4", text: "IV" },
            { value: "6", text: "VI" }
        ]
    };

    if (!opciones[ciclo]) return;

    // Opción por defecto
    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Seleccione semestre";
    semestreSelect.appendChild(defaultOption);

    opciones[ciclo].forEach(s => {
        const opt = document.createElement("option");
        opt.value = s.value;
        opt.textContent = s.text;
        semestreSelect.appendChild(opt);
    });

});
