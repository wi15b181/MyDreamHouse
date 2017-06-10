using SynchronisationDataManager;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SynchronisationLocalExecutor
{
    class Program
    {
        static void Main(string[] args)
        {
            DataManager dataManager = new DataManager();
            dataManager.FullSyncMySQLToDB2();
            Console.ReadLine();
        }
    }
}
