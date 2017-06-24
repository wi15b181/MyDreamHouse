using MySql.Data.MySqlClient;
using SynchronisationShared;
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
        private const string CONNECT_STRING = "server=localhost; port=443; userid=root; database=joomla";
       // private const string CONNECT_STRING = "server=wi-gate.technikum-wien.at; port=60431; userid=root; database=joomla; convert zero datetime=True";
        private MySqlConnection conn;
        public MySQLClient()
        {
            Logger.Info("Connecting to MySQL...");
            Connect();
            Logger.Info("Connection successful! [MySQL]");
        }
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
        protected override DataTable ExecuteQuery(string query)
        {
            DataTable dataTable = new DataTable();

            using (MySqlCommand cmd = new MySqlCommand(query, conn))
            {
                using (MySqlDataReader reader = cmd.ExecuteReader())
                {
                    dataTable.Load(reader);
                }
            }
            
            return dataTable;
        }

        public override void RollbackTransaction()
        {
            throw new NotImplementedException();
        }

        protected override void Close()
        {
           Logger.Info("Disconnecting MySQL...");
           conn.Close();
        }
    }
}
