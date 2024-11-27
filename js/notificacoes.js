try {
    let id = 1;
  const response = await fetch("notifica_atualiza.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `id=${id}`,
  });
  const data = await response.json();
  console.log(data);
} catch (error) {
  console.error("Erro ao enviar a requisição:", error);
}