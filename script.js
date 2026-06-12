window.addEventListener("load", () => {
    document.querySelectorAll("nav.topNav button").forEach(
        e => e.addEventListener("click", () => {
            if (e.classList.contains("topNav_tab_active")) return;

            document.querySelectorAll(".topNav_tab_active").forEach(t => t.classList.remove("topNav_tab_active"));
            document.querySelector(".topNav_tab_" + e.getAttribute("page")).classList.add("topNav_tab_active");
        })
    )
})
