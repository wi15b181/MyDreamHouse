using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SharedLibrary.Entities
{
    public class AttachmentsEntity
    {
        public int AttachementId { get; set; }

        public string Filename { get; set; }

        public string Bezeichnung { get; set; }

        public int Size { get; set; }

        public string Mimetype { get; set; }

        public int HauspaketId { get; set; }
    }
}
