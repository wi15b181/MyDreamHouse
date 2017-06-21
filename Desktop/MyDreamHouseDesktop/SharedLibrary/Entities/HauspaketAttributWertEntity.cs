using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SharedLibrary.Entities
{
    public class HauspaketAttributWertEntity
    {
        public int WertId { get; set; }

        public int AttributId { get; set; }

        public string WertText { get; set; }

        public int WertOrdnung { get; set; }

        public bool Archived { get; set; }
    }
}
