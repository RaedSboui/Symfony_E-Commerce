function showUsage(id) {
    var show_more = document.querySelector(".prod"+id);
    var usage = document.querySelector(".prodUsage"+id);

    //show usage
    show_more.addEventListener("click", () => {
        usage.classList.add("active");
    });
}



function removeUsage(id) {
    var close_usage = document.querySelector(".close-usage"+id);
    var usage = document.querySelector(".prodUsage"+id);
    //remove usage
    close_usage.addEventListener("click", () => {
        usage.classList.remove("active");
    });
}

