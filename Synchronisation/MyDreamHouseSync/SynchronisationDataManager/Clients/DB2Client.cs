using SynchronisationShared;
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

        public DB2Client()
        {
            Logger.Info("Connecting to DB2...");
            Connect();
            Logger.Info("Connection successful! [DB2]");
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
            Conn = factory.CreateConnection();
            Conn.ConnectionString = CONNECT_STRING;
            Conn.Open();
        }

        protected override DataTable ExecuteQuery(string query)
        {
            Logger.Info(query);
            DataTable dataTable = new DataTable();
            try
            {
                using (DbCommand dbcmd = Conn.CreateCommand())
                {
                    dbcmd.CommandType = CommandType.Text;
                    dbcmd.CommandText = query;

                    using (DbDataReader reader = dbcmd.ExecuteReader())
                    {
                        dataTable.Load(reader);
                    }
                }
            }
            catch (Exception ex)
            {
                Logger.Error(ex.Message);
            }
            return dataTable;
        }

        public override void RollbackTransaction()
        {
            throw new NotImplementedException();
        }

        protected override void Close()
        {
            Logger.Info("Disconnecting DB2...");
            Conn.Close();
        }
    }
}
