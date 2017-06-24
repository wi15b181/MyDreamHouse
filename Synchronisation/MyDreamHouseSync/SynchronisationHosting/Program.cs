using SynchronisationDataManager;
using SynchronisationService;
using SynchronisationShared;
using System;
using System.Collections.Generic;
using System.Linq;
using System.ServiceModel;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

namespace SynchronisationHosting
{
    class Program
    {
        static void Main(string[] args)
        {
            Logger.Info("Starting ServiceHost...");
            ServiceHost host = new ServiceHost(typeof(SynchronisationWCF));
            host.Open();
            Logger.Info("Synchronisation Service up and running.");
            DataManager dataManager = new DataManager();
            while (true)
            {
                Logger.Info("Syncing...");
                dataManager.FetchSyncEntriesIntoLocalDB();
                dataManager.SyncFromLocal();
                Wait(10);
            }
        }

        private static void Wait(int interval)
        {
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
        }
    }
}
