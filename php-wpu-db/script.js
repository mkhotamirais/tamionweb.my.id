const keyword = document.getElementById("keylive");
const container = document.getElementById("container");

keyword.addEventListener("keyup", function () {
  console.log("halo");
  fetch("dataLifeSearch.php?keyword=" + keyword.value)
    .then((response) => response.text())
    .then((response) => (container.innerHTML = response));
});
