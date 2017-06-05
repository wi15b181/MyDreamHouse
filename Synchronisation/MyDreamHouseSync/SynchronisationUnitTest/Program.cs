using SynchronisationDataManager;
using SynchronisationDataManager.Clients;
using SynchronisationShared;
using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using static SynchronisationDataManager.Clients.DatabaseClientFactory;

namespace SynchronisationUnitTest
{
    class Program
    {
        private const string MYSQL_TEST_QUERY = "select * from benutzer";
        static void Main(string[] args)
        {
            Logger.WriteInfo("Starting Unit text");

            Logger.WriteInfo("Obtaining MYSQL Client");
            DatabaseClient mysqlClient = DatabaseClientFactory.GetClient(ClientType.MYSQL);

            Logger.WriteInfo("Executing query MYSQL: "+MYSQL_TEST_QUERY);
            DataTable dataTable = mysqlClient.ExecuteQuery(MYSQL_TEST_QUERY);

            Logger.WriteInfo("Printing ResultSet");
            foreach (DataRow row in dataTable.Rows)
            {
                Console.WriteLine(row);
            }
            Console.ReadLine();
        }
    }
}
