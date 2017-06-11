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
        private const string PREFIX_ERROR = " [ERROR]: ";
        private const string PREFIX_INFO = " [INFO]: ";
        private const string ERROR = PREFIX + PREFIX_ERROR;
        private const string INFO = PREFIX + PREFIX_INFO;
        public static void Error(string text)
        {
            Console.WriteLine(ERROR + text);
        }

        public static void Info(string text)
        {
            Console.WriteLine(INFO + text);
        }
    }
}
