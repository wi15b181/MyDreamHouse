using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Common;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SynchronisationDataManager.Clients
{
    class DB2Client : DatabaseClient
    {
        private const string CONNECT_STRING = "Host=wi-gate.technikum-wien.at;port=60831;User ID = mydreahmouse; Password = wi15b; Database = mdh";
        DbProviderFactory factory = DbProviderFactories.GetFactory("DDTek.DB2");
        DbConnection Conn;
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
            Conn = factory.CreateConnection();
            Conn.ConnectionString = CONNECT_STRING;
            Conn.Open();
        }

        public override DataTable ExecuteQuery(string query)
        {
            DataTable dataTable = new DataTable();
            Connect();
            using (DbCommand dbcmd = Conn.CreateCommand())
            {
                dbcmd.CommandType = CommandType.Text;
                dbcmd.CommandText = query;

                using (DbDataReader reader = dbcmd.ExecuteReader())
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
            Conn.Close();
        }
    }
}
