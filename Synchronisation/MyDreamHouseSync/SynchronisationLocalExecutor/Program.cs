using SynchronisationDataManager;
using SynchronisationDataManager.Clients;
using SynchronisationShared;
using System;
using System.Collections.Generic;
using System.Data;
using System.Globalization;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using static SynchronisationShared.SharedEnums;

namespace SynchronisationLocalExecutor
{
    class Program
    {
        
        static void Main(string[] args)
        {
            /*DatabaseClient ClientMySQL = DatabaseClientFactory.GetClient(DatabaseType.MYSQL);
            DataTable syncJnTable = ClientMySQL.ExecuteQuery("select * from sync_jn where jn_synced = 0 order by jn_timestamp desc", null);
            foreach(DataRow row in syncJnTable.Rows)
            {
                Console.WriteLine(row[2]);
            }*/
            DataManager dm = new DataManager();
            dm.FullSyncMySQLToDB2();
            Console.ReadLine();
        }

        /*

        private static void Wait(int interval)
        {
            DataManager dataManager = new DataManager();
            while (true)
            {
                Logger.Info("Syncing...");
                dataManager.FetchSyncEntriesIntoLocalDB();
                dataManager.SyncFromLocal();
                Wait(10);
            }
            Logger.Info("Waiting for Sync");
            Console.WriteLine("Interval set to " + interval + " seconds");
            Console.WriteLine("40-------30--------20--------10---------Interval set to " + interval + " seconds");
            Console.WriteLine("|---------|---------|---------|---------|");
            for (int i = interval; i >= 0; i--)
            {
                Console.Write("|");
                Thread.Sleep(1000);
            }
            Console.WriteLine("");
        }*/
    }
}
