import React, { useEffect, useState } from 'react';
import { makeStyles } from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import Paper from '@material-ui/core/Paper';
import apiService from '../api/apiService'; 

const useStyles = makeStyles({
  table: {
    minWidth: 650,
  },
});

export default function TabelaVendasTotal() {
  const classes = useStyles();
  const [tableData, setTableData] = useState([]);

  useEffect(() => {
    // Função para buscar dados do PHP
    const fetchData = async () => {
      try {
        const response = await fetch('http://localhost:8080/lucca/dashboard_vendas/vendas/venda_total.php?intervalo=semana');

        const data = await response.json();
        setTableData(data);
      } catch (error) {
        console.error('Erro ao buscar dados:', error);
      }
    };

    // Chama a função para buscar dados ao carregar o componente
    fetchData();
  }, []); // O segundo parâmetro [] garante que o efeito só será executado uma vez (equivalente a componentDidMount)

  return (
    <TableContainer component={Paper}>
      <Table className={classes.table} size="small" aria-label="a dense table">
        <TableHead>
          <TableRow>
            <TableCell>Total</TableCell>
            <TableCell align="right">Vendas</TableCell>
            <TableCell align="right">TM</TableCell>
            <TableCell align="right">Meta</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {tableData.map((row) => (
            <TableRow key={row.VENDEDOR}>
              <TableCell component="th" scope="row">
                {row.VENDEDOR}
              </TableCell>
              <TableCell align="right">{row.VENDAS}</TableCell>
              <TableCell align="right">{row.TM}</TableCell>
              <TableCell align="right">{row.META}</TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </TableContainer>
  );
}
