using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.ServiceModel;
using System.Text;

namespace SynchronisationService
{
    // HINWEIS: Mit dem Befehl "Umbenennen" im Menü "Umgestalten" können Sie den Klassennamen "SynchronisationWCF" sowohl im Code als auch in der Konfigurationsdatei ändern.
    public class SynchronisationWCF : ISynchronisationWCF
    {
        public int Ping()
        {
            return 1;
        }
    }
}
