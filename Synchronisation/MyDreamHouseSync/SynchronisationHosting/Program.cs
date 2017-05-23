using SynchronisationService;
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
            ServiceHost host = new ServiceHost(typeof(SynchronisationWCF));
            host.Open();

            Console.WriteLine("Pull the lever, Kronk!");
            Console.ReadLine();
            Console.WriteLine("Wrong lever! Wrong lever!");
            Thread.Sleep(2000);

        }
    }
}
