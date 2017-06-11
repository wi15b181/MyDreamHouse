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
using static SynchronisationShared.SharedEnums;

namespace SynchronisationUnitTest
{
    class Program
    {
        private const string MYSQL_TEST_QUERY = "select * from benutzer";
        private const string DB2_TEST_QUERY = "select * from hauspaket_attribut";
        static void Main(string[] args)
        {
            Logger.Info("Starting Unit Test");

            TestMySQL();
            TestDB2();

            Logger.Info("Unit Test Successful");

            Console.ReadLine();
        }

        private static void TestMySQL()
        {
            Logger.Info("Start TestMySQL ");

            Logger.Info("Obtaining MYSQL Client");
            DatabaseClient mysqlClient = DatabaseClientFactory.GetClient(DatabaseType.MYSQL);

            Logger.Info("Executing query MYSQL: " + MYSQL_TEST_QUERY);
            DataTable dataTable = mysqlClient.ExecuteQuery(MYSQL_TEST_QUERY,null);

            Logger.Info("Printing ResultSet");
            foreach (DataRow row in dataTable.Rows)
            {
                Console.WriteLine(row);
            }
        }
        private static void TestDB2()
        {
            Logger.Info("Start TestDB2 ");

            Logger.Info("Obtaining DB2 Client");
            DatabaseClient mysqlClient = DatabaseClientFactory.GetClient(DatabaseType.DB2);

            Logger.Info("Executing query DB2: " + DB2_TEST_QUERY);
            DataTable dataTable = mysqlClient.ExecuteQuery(DB2_TEST_QUERY,null);

            Logger.Info("Printing ResultSet");
            foreach (DataRow row in dataTable.Rows)
            {
                Console.WriteLine(row);
            }
        }
    }
}
