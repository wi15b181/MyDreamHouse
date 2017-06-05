using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SynchronisationDataManager.Clients
{
    class MySQLClient : DatabaseClient
    {
        private const string CONNECT_STRING = "server=wi-gate.technikum-wien.at; port=60431; userid=root; database=joomla";
        private MySqlConnection conn;

        public override void BeginTransaction()
        {
            throw new NotImplementedException();
        }

        public override void CommitTransaction()
        {
            throw new NotImplementedException();
        }

        protected override void Connect()
        {
            conn = new MySqlConnection();
            conn.ConnectionString = CONNECT_STRING;
            try
            {
                conn.Open();
            }
            catch (Exception ex1)
            {
                Console.WriteLine(ex1.Message); // Implement real exception handling... or not... #herebedragons
            }
        }

        public override DataTable ExecuteQuery(string query)
        {
            DataTable dataTable = new DataTable();

            Connect();

            using (MySqlCommand cmd = new MySqlCommand(query, conn))
            {
                using (MySqlDataReader reader = cmd.ExecuteReader())
                {
                    dataTable.Load(reader);
                }
            }

            Close();

            return dataTable;
        }

        public override void RollbackTransaction()
        {
            throw new NotImplementedException();
        }

        protected override void Close()
        {
           conn.Close();
        }
    }
}
