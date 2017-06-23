using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SharedLibrary.Entities
{
    public class BeraterEntity
    {
        public int BeraterId { get; set; }
        public Nullable<int> HerstellerId { get; set; }
        public Nullable<int> BenutzerId { get; set; }
        public string Bild { get; set; }
    }
}
