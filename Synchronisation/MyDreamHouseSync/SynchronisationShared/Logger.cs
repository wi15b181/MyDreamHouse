using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SynchronisationShared
{
    public class Logger
    {
        private const string PREFIX = "############";
        private const string PREFIX_ERROR = " [ERROR]:";
        private const string PREFIX_INFO = " [INFO]:";
        public static void WriteError(string text)
        {
            Console.WriteLine(PREFIX + PREFIX_ERROR + text);
        }

        public static void WriteInfo(string text)
        {
            Console.WriteLine(PREFIX + PREFIX_INFO + text);
        }
    }
}
