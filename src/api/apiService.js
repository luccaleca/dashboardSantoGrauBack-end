const apiUrl = 'http://localhost:8080/lucca/dashboard_vendas/vendas/venda_whatsapp.php?intervalo=semana';




const apiService = {
  fetchData: async () => {
    try {
      const response = await fetch(apiUrl);
      console.log(response); // linha para verificar a resposta no console


      if (!response.ok) {
        throw new Error(`Erro na requisição: ${response.status}`);
      }
      const data = await response.json();
      console.log(data); // console.log para verificar os dados
      return data;
    } catch (error) {
      console.error('Erro na requisição:', error);
      throw error;
    }
  },
};

export default apiService;
